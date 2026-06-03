<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'c1', 'c2', 'c3', 'c4',
        'skor_akhir', 'kpi_score',
        'bakat_dominan', 'insight_kinerja',
        'ranking', 'is_verified',
        'kepsek_status', 'kepsek_catatan', 'kepsek_reviewed_at',
        'is_published',
        'berita_publikasi', 'admin_catatan', 'admin_published_by', 'admin_published_at', 'status_publikasi',
        'is_proposed', 'is_recommended'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function prestasi()
    {
        return $this->hasOne(Prestasi::class, 'siswa_id', 'siswa_id')->latestOfMany();
    }

    protected static function normalizeScore($score)
    {
        return max(0, min(100, $score));
    }

    protected static function isAcademicPrestasi($kategori)
    {
        if (!$kategori) return false;
        return $kategori->id == 2 || $kategori->parent_id == 2;
    }

    protected static function isNonAcademicPrestasi($kategori)
    {
        if (!$kategori) return false;
        return $kategori->id == 4 || $kategori->parent_id == 4;
    }

    protected static function isOrganizationPrestasi($kategori)
    {
        if (!$kategori) return false;
        return $kategori->id == 3 || $kategori->parent_id == 3;
    }

    protected static function getHighestPrestasiScore($prestasis, $matcher)
    {
        return $prestasis->filter($matcher)
            ->map(fn($p) => self::normalizeScore($p->poin))
            ->max() ?? 0;
    }

    public static function getKpiIndicators($siswaId)
    {
        $c1Val = NilaiSiswa::where('siswa_id', $siswaId)->avg('nilai') ?? 0;

        $studentPrestasis = Prestasi::where('siswa_id', $siswaId)
            ->where('status', 'disetujui')
            ->with('kategori')
            ->get();

        $c2Val = self::getHighestPrestasiScore($studentPrestasis, function($p) {
            return self::isAcademicPrestasi($p->kategori);
        });

        $c4Val = self::getHighestPrestasiScore($studentPrestasis, function($p) {
            return self::isNonAcademicPrestasi($p->kategori);
        });

        $c3Val = self::getHighestPrestasiScore($studentPrestasis, function($p) {
            return self::isOrganizationPrestasi($p->kategori);
        });

        if ($c3Val === 0) {
            $existingPenilaian = self::where('siswa_id', $siswaId)->first();
            if ($existingPenilaian) {
                $legacyC3 = $existingPenilaian->c3;
                $legacyMap = [
                    0 => 75,
                    1 => 88,
                    2 => 85,
                    3 => 90,
                    4 => 95,
                ];
                $c3Val = array_key_exists($legacyC3, $legacyMap)
                    ? $legacyMap[$legacyC3]
                    : self::normalizeScore($legacyC3);
            } else {
                $c3Val = 0;
            }
        }

        return [
            'c1' => self::normalizeScore($c1Val),
            'c2' => self::normalizeScore($c2Val),
            'c3' => self::normalizeScore($c3Val),
            'c4' => self::normalizeScore($c4Val),
        ];
    }

    public static function kalkulasiKpiSiswa($siswaId)
    {
        $siswa = Siswa::find($siswaId);
        if (!$siswa) return;

        $indicators = self::getKpiIndicators($siswaId);
        $c1Val = $indicators['c1'];
        $c2Val = $indicators['c2'];
        $c3Val = $indicators['c3'];
        $c4Val = $indicators['c4'];

        $weights = KpiSetting::all()->pluck('weight', 'code');
        $wA = $weights['A'] ?? 0.25;
        $wB = $weights['B'] ?? 0.25;
        $wC = $weights['C'] ?? 0.25;
        $wD = $weights['D'] ?? 0.25;

        $nA = min($c1Val / 100, 1);
        $nB = min($c2Val / 100, 1);
        $nC = min($c3Val / 100, 1);
        $nD = min($c4Val / 100, 1);

        $totalSkor = ($nA * $wA) + ($nB * $wB) + ($nC * $wC) + ($nD * $wD);

        $scores = ['A' => $nA, 'B' => $nB, 'C' => $nC, 'D' => $nD];
        $maxScore = max($scores);
        $dominantKey = array_keys($scores, $maxScore)[0];

        $bakat = match($dominantKey) {
            'A' => 'Akademik Umum (Intellectual)',
            'B' => 'Akademik Spesifik (Specific Academic)',
            'C' => 'Organisasi & Kepemimpinan (General Social)',
            'D' => 'Seni & Olahraga (General Arts)',
        };

        $kategori = 'Kurang';
        if ($totalSkor >= 0.8) $kategori = 'Sangat Baik';
        elseif ($totalSkor >= 0.6) $kategori = 'Baik';
        elseif ($totalSkor >= 0.4) $kategori = 'Cukup';

        self::updateOrCreate(
            ['siswa_id' => $siswaId],
            [
                'c1' => $c1Val,
                'c2' => $c2Val,
                'c3' => $c3Val,
                'c4' => $c4Val,
                'skor_akhir' => $totalSkor,
                'kpi_score' => $totalSkor * 100,
                'bakat_dominan' => $bakat,
                'insight_kinerja' => "Kinerja siswa berkategori " . $kategori . ".",
                'is_verified' => true
            ]
        );

        if ($siswa->walikelas_id) {
            $classSiswas = Siswa::where('walikelas_id', $siswa->walikelas_id)->get();
            $rankData = [];
            foreach ($classSiswas as $cs) {
                $p = self::where('siswa_id', $cs->id)->first();
                $rankData[] = [
                    'siswa_id' => $cs->id,
                    'skor_akhir' => $p ? ($p->skor_akhir ?? 0) : 0
                ];
            }
            usort($rankData, function($a, $b) {
                return $b['skor_akhir'] <=> $a['skor_akhir'];
            });
            foreach ($rankData as $rank => $rd) {
                self::where('siswa_id', $rd['siswa_id'])->update(['ranking' => $rank + 1]);
            }
        }
    }
}
