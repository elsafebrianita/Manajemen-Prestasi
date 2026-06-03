<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Http\Controllers\KepsekController;
use Illuminate\Http\Request;

$u = User::where('name', 'like', '%Wiskatrina%')->first();
auth()->login($u);

echo "User: {$u->name}, AksesRole: " . auth()->user()->akses_role . "\n";

try {
    $c = new KepsekController();
    $c->adminPublikasi();
    echo "Access granted! (No 403)\n";
} catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
    echo "Access denied with status code: " . $e->getStatusCode() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
