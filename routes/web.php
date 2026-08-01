<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AsuransiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VarianController;
use App\Http\Controllers\WarnaController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\CabangController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bp', [PiutangController::class, 'indexBp']);
    Route::post('/bp', [PiutangController::class, 'storeBp']);
    Route::get('/bp/{id}/edit', [PiutangController::class, 'editBp'])->whereNumber('id');
    Route::put('/bp/{id}', [PiutangController::class, 'updateBp'])->whereNumber('id');
    Route::delete('/bp/{id}', [PiutangController::class, 'destroyBp'])->whereNumber('id');

    Route::prefix('gr/{branch}')->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])->group(function () {
        Route::get('/', [PiutangController::class, 'indexGr']);
        Route::post('/', [PiutangController::class, 'storeGr']);
        Route::get('/{id}/edit', [PiutangController::class, 'editGr'])->whereNumber('id');
        Route::put('/{id}', [PiutangController::class, 'updateGr'])->whereNumber('id');
        Route::delete('/{id}', [PiutangController::class, 'destroyGr'])->whereNumber('id');
    });

    Route::get('/asuransi/list', function () {
        return \App\Models\Asuransi::select('id', 'nama')->orderBy('nama')->get();
    })->name('asuransi.list');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('asuransi', AsuransiController::class);
        Route::resource('users', UserController::class);
        Route::resource('perusahaan', PerusahaanController::class);

        Route::get('stocks/report', [StockController::class, 'report'])->name('stocks.report');
        Route::get('stocks/report/export-pdf', [StockController::class, 'exportReportPdf'])->name('stocks.report.exportPdf');
        Route::get('stocks/report/export-excel', [StockController::class, 'exportReportExcel'])->name('stocks.report.exportExcel');
        Route::get('stocks/export-pdf', [StockController::class, 'exportPdf'])->name('stocks.exportPdf');
        Route::get('stocks/export-excel', [StockController::class, 'exportExcel'])->name('stocks.exportExcel');
        Route::get('stocks/print', [StockController::class, 'print'])->name('stocks.print');
        Route::resource('stocks', StockController::class);

        Route::resource('units', UnitController::class);
        Route::resource('varians', VarianController::class);
        Route::resource('warnas', WarnaController::class);
        Route::resource('gudangs', GudangController::class);
        Route::resource('cabangs', CabangController::class);
        Route::resource('in-units', \App\Http\Controllers\InUnitController::class);
        Route::get('in-units/export-excel', [\App\Http\Controllers\InUnitController::class, 'exportExcel'])->name('in-units.exportExcel');
    });

    Route::prefix('dev-tools')->group(function () {

        Route::get('/bersihin-cache-it', function() {
            Artisan::call('config:clear');
            return "MANTAP! Cache .env Suzuki Duta Cendana berhasil dihapus tanpa terminal!";
        });

        Route::get('/jalankan-inunit-seeder', function () {
            Artisan::call('db:seed', ['--class' => 'InUnitSeeder']);
            return '<h1>SELESAI!</h1>
                    1. Akun Piutang Jatiasih & Cinere sudah dikembalikan seperti semula.<br>
                    2. Akun Khusus IN UNIT berhasil dibuat:<br>
                    <b>Email:</b> inunit.jatiasih@suzuki.com | <b>Pass:</b> Jatiasih123!<br>
                    <b>Email:</b> inunit.cinere@suzuki.com | <b>Pass:</b> Cinere123!';
        });

        Route::get('/panggil-semua-seeder', function () {
            Artisan::call('db:seed', ['--class' => 'AdminStockSeeder']);
            Artisan::call('db:seed', ['--class' => 'InUnitSeeder']);
            Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
            return "Sukses! Admin Stock dan Admin In Unit berhasil dipanggil kembali dari kematian. Silakan login!";
        });



        Route::get('/jalankan-migrate', function () {
            Artisan::call('migrate', ['--force' => true]);
            return nl2br(Artisan::output());
        });

        Route::get('/jalankan-seeder', function () {
            Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
            return nl2br(Artisan::output());
        });

        Route::get('/fix-overdue-perusahaan', function () {
            if (!Schema::hasColumn('perusahaan', 'overdue')) {
                Schema::table('perusahaan', function ($table) {
                    $table->integer('overdue')->default(28)->after('deskripsi');
                });
                return 'Kolom overdue berhasil ditambahkan';
            }
            return 'Kolom overdue sudah ada';
        });

        Route::get('/kirim-stock-sekarang', function() {
            Artisan::call('app:send-stock-email');
            return nl2br("=== Hasil Send Stock Email ===\n" . Artisan::output());
        });

        Route::get('/kirim-unit-sekarang', function() {
            Artisan::call('app:send-in-unit-email');
            return nl2br("=== Hasil Send In Unit Email ===\n" . Artisan::output());
        });

        Route::get('/kirim-ar-sekarang', function() {
            Artisan::call('app:send-weekly-branch-data-email');
            return nl2br("=== Hasil Send Weekly Branch Data Email ===\n" . Artisan::output());
        });

        Route::get('/clear-optimize', function () {
            Artisan::call('optimize:clear');
            return '<pre>' . Artisan::output() . '</pre>';
        });


        Route::get('/cek-schedule-file', function () {
            return file_get_contents(base_path('routes/console.php'));
        });

        Route::get('/cek-jam', function () {
            return [
                'utc' => now()->toDateTimeString(),
                'jakarta' => now('Asia/Jakarta')->toDateTimeString(),
            ];
        });
    });

});
