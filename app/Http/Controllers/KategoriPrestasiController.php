<?php

namespace App\Http\Controllers;

use App\Models\KategoriPrestasi;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class KategoriPrestasiController extends Controller
{
    // tampil semua kategori
    public function index()
    {
        $kategoris = KategoriPrestasi::all();
        return view('kategori.index', compact('kategoris'));
    }

    // klik kategori → tampil prestasi
    public function show($id)
    {
        $kategori = KategoriPrestasi::find($id);

        $jenis_prestasi = KategoriPrestasi::where('parent_id', $id)->get();

        return view('kategori.show', compact('kategori', 'jenis_prestasi'));
    }

    // form tambah kategori
    public function create()
    {
        return view('kategori.create');
    }

    // simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        KategoriPrestasi::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }
}