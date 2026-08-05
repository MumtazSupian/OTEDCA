Illuminate\Database\QueryException
vendor\laravel\framework\src\Illuminate\Database\Connection.php:838
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'user_id' in 'where clause' (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: ote_dca, SQL: select * from `actual_salesforces` where `grading` = FREELANCE and `tahun` = 2026 and `user_id` = 11 limit 1)<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sales\vsv\activity\ActualActivity;
use App\Http\Controllers\Sales\vsv\activity\ActualActivityController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

$user = User::where('email', 'AdminArStock@gmail.com')->first();
if ($user) Auth::login($user);

$req = new Request();
$req->merge([
    'jenis_activity'  => 'Offline',
    'activity'        => 'EXHIBITION',
    'platform_lokasi' => 'JAKARTA',
    'jenis_unit'      => 'Passenger',
    'type_unit'       => 'XL7',
    'tanggal'         => '2026-08-05',
    'jam'             => '11:15',
    'jml_sales_shift' => 3,
    'pic'             => 'BUDI',
    'target_p'        => 5,
    'target_hp'       => 4,
    'target_spk'      => 3,
    'actual_p'        => 5,
    'actual_hp'       => 4,
    'actual_spk'      => 3,
    'actual_do'       => 2,
    'total_cost'      => 5000000,
    'keterangan'      => 'Actual Activity Demo'
]);

$controller = new ActualActivityController();
$response = $controller->store($req);

echo "Store Response Status: " . $response->getStatusCode() . "\n";
echo "Total records in ActualActivity DB: " . ActualActivity::count() . "\n";

$view = $controller->index();
$data = $view->getData()['data'];

echo "Index View Returned Rows: " . count($data) . "\n";
if (count($data) > 0) {
    echo "First Row: ID={$data[0]->id}, PIC={$data[0]->pic}, Activity={$data[0]->activity}, Cabang={$data[0]->cabang}\n";
}
