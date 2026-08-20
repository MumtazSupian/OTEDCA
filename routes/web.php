<?php

use App\Http\Controllers\Sales\vsv\DashboardController;
use App\Http\Controllers\AuthController;
// Finance Controllers
use App\Http\Controllers\Finance\PiutangController;
use App\Http\Controllers\Finance\AsuransiController;
use App\Http\Controllers\Finance\UserController;
use App\Http\Controllers\Finance\PerusahaanController;
// Sales Controllers
use App\Http\Controllers\Sales\StockController;
use App\Http\Controllers\Sales\UnitController;
use App\Http\Controllers\Sales\VarianController;
use App\Http\Controllers\Sales\WarnaController;
use App\Http\Controllers\Sales\GudangController;
use App\Http\Controllers\Sales\CabangController;
use App\Http\Controllers\Sales\InUnitController;
use App\Http\Controllers\Service\ServiceAcController;
use App\Http\Controllers\Service\PostCheckAcController;
use App\Http\Controllers\Service\PreCheckAcController;
// Sales VSV
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sales\vsv\rka\TargetDoUnitController;
use App\Http\Controllers\Sales\vsv\rka\TargetSalesforceController;
use App\Http\Controllers\Sales\vsv\rka\TargetInquiryController;
use App\Http\Controllers\Sales\vsv\rka\TargetDoBySoiController;

use App\Http\Controllers\Sales\vsv\TargetRkaController;
use App\Http\Controllers\Sales\vsv\ActualController;

use App\Http\Controllers\Sales\vsv\leasing\AktualAplikasiInController;
use App\Http\Controllers\Sales\vsv\leasing\AktualPoController;
use App\Http\Controllers\Sales\vsv\leasing\AktualRejectController;

use App\Http\Controllers\Sales\vsv\activity\PlanActivityController;
use App\Http\Controllers\Sales\vsv\activity\ActualActivityController;

use App\Http\Controllers\Sales\vsv\current\ActualDoByTypeController;
use App\Http\Controllers\Sales\vsv\current\ActualDoSalesForceController;
use App\Http\Controllers\Sales\vsv\current\ActualInquaryByTypeController;
use App\Http\Controllers\Sales\vsv\current\ActualSalesByLeasingController;
use App\Http\Controllers\Sales\vsv\current\ActualSalesForceController;
use App\Http\Controllers\Sales\vsv\current\ActualSourceDoInquaryController;
use App\Http\Controllers\Sales\vsv\current\ActualSourceInquaryController;
use App\Http\Controllers\Sales\vsv\current\ActualSpkByTypeController;

use App\Http\Controllers\Sales\vsv\evaluasi\EvaluasiWiraniagaController;

use App\Http\Controllers\Sales\vsv\summary\SummaryController;
use App\Http\Controllers\Sales\vsv\summary\SummaryActionController;

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
    Route::get('/finance/dashboard', [\App\Http\Controllers\Finance\DashboardController::class, 'index'])->name('finance.dashboard');
    Route::get('/sales/dashboard', [\App\Http\Controllers\Sales\DashboardController::class, 'index'])->name('sales.dashboard');
    Route::get('/sales/dashboard_sales', [\App\Http\Controllers\Sales\DashboardSalesController::class, 'index'])->name('sales.dashboard_sales');

    Route::get('/sales/vsv/dashboard/v1', [\App\Http\Controllers\Sales\vsv\DashboardController::class, 'v1'])->name('sales.vsv.dashboard.v1');
    Route::get('/sales/vsv/dashboard/v1/export-pdf', [\App\Http\Controllers\Sales\vsv\DashboardController::class, 'exportPdfV1'])->name('sales.vsv.dashboard.v1.export_pdf');
    Route::get('/sales/vsv/dashboard/v2', [\App\Http\Controllers\Sales\vsv\DashboardController::class, 'v2'])->name('sales.vsv.dashboard.v2');

    Route::get('/bp', [PiutangController::class, 'indexBp'])->name('bp.index');
    Route::post('/bp', [PiutangController::class, 'storeBp'])->name('bp.store');
    Route::get('/bp/{id}/edit', [PiutangController::class, 'editBp'])->whereNumber('id')->name('bp.edit');
    Route::put('/bp/{id}', [PiutangController::class, 'updateBp'])->whereNumber('id')->name('bp.update');
    Route::delete('/bp/{id}', [PiutangController::class, 'destroyBp'])->whereNumber('id')->name('bp.destroy');

    Route::prefix('gr/{branch}')->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])->group(function () {
        Route::get('/', [PiutangController::class, 'indexGr'])->name('gr.index');
        Route::post('/', [PiutangController::class, 'storeGr'])->name('gr.store');
        Route::get('/{id}/edit', [PiutangController::class, 'editGr'])->whereNumber('id')->name('gr.edit');
        Route::put('/{id}', [PiutangController::class, 'updateGr'])->whereNumber('id')->name('gr.update');
        Route::delete('/{id}', [PiutangController::class, 'destroyGr'])->whereNumber('id')->name('gr.destroy');
    });

    Route::get('/asuransi/list', function () {
        return \App\Models\Finance\Asuransi::select('id', 'nama')->orderBy('nama')->get();
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
        Route::resource('in-units', InUnitController::class);
        Route::get('in-units/export-excel', [InUnitController::class, 'exportExcel'])->name('in-units.exportExcel');
    });

Route::middleware(['auth', 'no-direct'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/v1', [DashboardController::class, 'v1'])->name('dashboard.v1');
    Route::get('/dashboard/v2', [DashboardController::class, 'v2'])->name('dashboard.v2');

    Route::resource('users', UserController::class);

    Route::prefix('target')->group(function () {
        Route::get('/salesforce', [TargetRkaController::class, 'salesforce'])->name('target.salesforce');
        Route::get('/do-unit', [TargetRkaController::class, 'doUnit'])->name('target.do_unit');
        Route::get('/do-by-soi', [TargetRkaController::class, 'doBySoi'])->name('target.do_by_soi');
    });

    Route::prefix('actual')->name('actual.')->group(function () {
        Route::get('/do-by-type', [ActualController::class, 'doByType'])->name('do_by_type');
        Route::get('/spk-by-type', [ActualController::class, 'spkByType'])->name('spk_by_type');
        Route::get('/inquiry-by-type', [ActualController::class, 'inquiryByType'])->name('inquiry_by_type');
        Route::get('/source-inquiry', [ActualController::class, 'sourceInquiry'])->name('source_inquiry');
        Route::get('/source-do-inquiry', [ActualController::class, 'sourceDoInquiry'])->name('source_do_inquiry');
        Route::get('/salesforces', [ActualController::class, 'salesforces'])->name('salesforces');
        Route::get('/do-salesforces', [ActualController::class, 'doSalesforces'])->name('do_salesforces');
        Route::get('/sales-by-leasing', [ActualController::class, 'salesByLeasing'])->name('sales_by_leasing');
    });

    Route::prefix('rka')->name('rka.')->group(function () {
        Route::get('/dashboard', function () {
            return view(view()->exists('Sales.vsv.rka.dashboard_rka') ? 'Sales.vsv.rka.dashboard_rka' : 'rka.dashboard_rka');
        });
        Route::get('target-do-unit/export-pdf', [TargetDoUnitController::class, 'exportPdf'])->name('target-do-unit.pdf');
        Route::get('target-do-unit/export-excel', [TargetDoUnitController::class, 'exportExcel'])->name('target-do-unit.excel');
        Route::get('target-inquiries/export-pdf', [TargetInquiryController::class, 'exportPdf'])->name('target-inquiries.pdf');
        Route::get('target-inquiries/export-excel', [TargetInquiryController::class, 'exportExcel'])->name('target-inquiries.excel');
        Route::get('target-do-by-soi/pdf', [TargetDoBySoiController::class, 'exportPdf'])->name('target-do-by-soi.pdf');
        Route::get('target-do-by-soi/excel', [TargetDoBySoiController::class, 'exportExcel'])->name('target-do-by-soi.excel');
        Route::get('target-salesforces/pdf', [TargetSalesforceController::class, 'exportPdf'])->name('target-salesforces.pdf');
        Route::get('target-salesforces/excel', [TargetSalesforceController::class, 'exportExcel'])->name('target-salesforces.excel');
        Route::resource('target-do-units', TargetDoUnitController::class);
        Route::resource('target-salesforces', TargetSalesforceController::class);
        Route::resource('target-inquiries', TargetInquiryController::class);
        Route::resource('target-do-by-soi', TargetDoBySoiController::class);
    });

    Route::prefix('leasing')->name('leasing.')->group(function () {
        Route::get('/dashboard', function () {
            return view(view()->exists('Sales.vsv.leasing.dashboard_leasing') ? 'Sales.vsv.leasing.dashboard_leasing' : 'leasing.dashboard_leasing');
        });
        Route::get('aktual-aplikasi-in/export-pdf', [AktualAplikasiInController::class, 'exportPdf'])->name('aktual-aplikasi-in.pdf');
        Route::get('aktual-aplikasi-in/export-excel', [AktualAplikasiInController::class, 'exportExcel'])->name('aktual-aplikasi-in.excel');
        Route::get('aktual-po/export-excel', [AktualPoController::class, 'exportExcel'])->name('aktual-po.excel');
        Route::get('aktual-po/export-pdf', [AktualPoController::class, 'exportPdf'])->name('aktual-po.pdf');
        Route::get('aktual-reject/export-excel', [AktualRejectController::class, 'exportExcel'])->name('aktual-reject.excel');
        Route::get('aktual-reject/export-pdf', [AktualRejectController::class, 'exportPdf'])->name('aktual-reject.pdf');
        Route::resource('aktual-aplikasi-in', AktualAplikasiInController::class);
        Route::resource('aktual-po', AktualPoController::class);
        Route::resource('aktual-reject', AktualRejectController::class);
    });


    Route::prefix('activity')->name('activity.')->group(function () {
        Route::get('/dashboard', function () {
            return view(view()->exists('Sales.vsv.activity.dashboard_activity') ? 'Sales.vsv.activity.dashboard_activity' : 'activity.dashboard_activity');
        });
        Route::get('plan/export-excel', [PlanActivityController::class, 'exportExcel'])->name('plan.excel');
        Route::get('plan/export-pdf', [PlanActivityController::class, 'exportPdf'])->name('plan.pdf');
        
        Route::get('actual/export-excel', [ActualActivityController::class, 'exportExcel'])->name('actual.excel');
        Route::get('actual/export-pdf', [ActualActivityController::class, 'exportPdf'])->name('actual.pdf');

        Route::resource('plan', PlanActivityController::class);
        Route::resource('actual', ActualActivityController::class);
    });


    Route::prefix('current')->name('current.')->group(function () {
        Route::get('/dashboard', function () {
            return view(view()->exists('Sales.vsv.current.dashboard_current') ? 'Sales.vsv.current.dashboard_current' : 'current.dashboard_current');
        });
        Route::get('/actual-do-by-type/export-excel', [ActualDoByTypeController::class, 'exportExcel'])->name('actual-do-by-type.excel');
        Route::get('/actual-do-by-type/export-pdf', [ActualDoByTypeController::class, 'exportPdf'])->name('actual-do-by-type.pdf');
        Route::get('/actual-do-salesforces/export-excel', [ActualDoSalesForceController::class, 'exportExcel'])->name('actual-do-salesforces.excel');
        Route::get('/actual-do-salesforces/export-pdf', [ActualDoSalesForceController::class, 'exportPdf'])->name('actual-do-salesforces.pdf');
        Route::get('/actual-inquary-by-type/export-excel', [ActualInquaryByTypeController::class, 'exportExcel'])->name('actual-inquary-by-type.excel');
        Route::get('/actual-inquary-by-type/export-pdf', [ActualInquaryByTypeController::class, 'exportPdf'])->name('actual-inquary-by-type.pdf');
        Route::get('/actual-sales-by-leasing/export-excel', [ActualSalesByLeasingController::class, 'exportExcel'])->name('actual-sales-by-leasing.excel');
        Route::get('/actual-sales-by-leasing/export-pdf', [ActualSalesByLeasingController::class, 'exportPdf'])->name('actual-sales-by-leasing.pdf');
        Route::get('/actual-salesforces/export-excel', [ActualSalesForceController::class, 'exportExcel'])->name('actual-salesforces.excel');
        Route::get('/actual-salesforces/export-pdf', [ActualSalesForceController::class, 'exportPdf'])->name('actual-salesforces.pdf');
        Route::get('/actual-source-do-inquary/export-excel', [ActualSourceDoInquaryController::class, 'exportExcel'])->name('actual-source-do-inquary.excel');
        Route::get('/actual-source-do-inquary/export-pdf', [ActualSourceDoInquaryController::class, 'exportPdf'])->name('actual-source-do-inquary.pdf');
        Route::get('/actual-source-inquary/export-excel', [ActualSourceInquaryController::class, 'exportExcel'])->name('actual-source-inquary.excel');
        Route::get('/actual-source-inquary/export-pdf', [ActualSourceInquaryController::class, 'exportPdf'])->name('actual-source-inquary.pdf');
        Route::get('/actual-spk-by-type/export-excel', [ActualSpkByTypeController::class, 'exportExcel'])->name('actual-spk-by-type.excel');
        Route::get('/actual-spk-by-type/export-pdf', [ActualSpkByTypeController::class, 'exportPdf'])->name('actual-spk-by-type.pdf');

        Route::resource('actual-do-by-type', ActualDoByTypeController::class);
        Route::resource('actual-do-salesforces', ActualDoSalesForceController::class);
        Route::resource('actual-inquary-by-type', ActualInquaryByTypeController::class);
        Route::resource('actual-sales-by-leasing', ActualSalesByLeasingController::class);
        Route::resource('actual-salesforces', ActualSalesForceController::class);
        Route::resource('actual-source-do-inquary', ActualSourceDoInquaryController::class);
        Route::resource('actual-source-inquary', ActualSourceInquaryController::class);
        Route::resource('actual-spk-by-type', ActualSpkByTypeController::class);
    });


    Route::prefix('evaluasi')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('evaluasi.index');
        });
        Route::get('/evaluasi/export/excel', [EvaluasiWiraniagaController::class, 'exportExcel'])->name('evaluasi.excel');
        Route::get('/evaluasi/export/pdf', [EvaluasiWiraniagaController::class, 'exportPdf'])->name('evaluasi.pdf');

        Route::resource('evaluasi', EvaluasiWiraniagaController::class);
    });


    Route::prefix('summary')->name('summary.')->group(function () {
        Route::get('/dashboard', function () {
            return view(view()->exists('Sales.vsv.summary.dashboard_summary') ? 'Sales.vsv.summary.dashboard_summary' : 'summary.dashboard_summary');
        });
        Route::get('/summary/export/excel', [SummaryController::class, 'exportExcel'])->name('summary.excel');
        Route::get('/summary/export/pdf', [SummaryController::class, 'exportPdf'])->name('summary.pdf');
        Route::get('/summary-action/export/excel', [SummaryActionController::class, 'exportExcel'])->name('summary-action.excel');
        Route::get('/summary-action/export/pdf', [SummaryActionController::class, 'exportPdf'])->name('summary-action.pdf');

        Route::resource('summary', SummaryController::class);
        Route::resource('summaryaction', SummaryActionController::class);
    });

    Route::get('/sales/leads/{cabang}', [\App\Http\Controllers\LeadController::class, 'index'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    // Leads Dashboard
    Route::get('/sales/leads/dashboard', [\App\Http\Controllers\Sales\LeadsDashboardController::class, 'index'])->name('sales.leads.dashboard');

    Route::get('/sales/leads/{cabang}/create', [\App\Http\Controllers\LeadController::class, 'create'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::post('/sales/leads/{cabang}/store', [\App\Http\Controllers\LeadController::class, 'store'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);

    // Leads
    Route::get('/sales/leads/{cabang}/leads', [\App\Http\Controllers\LeadController::class, 'index'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    
    Route::get('/sales/leads/{cabang}/leads/create', [\App\Http\Controllers\LeadController::class, 'create'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    
    Route::post('/sales/leads/{cabang}/leads/store', [\App\Http\Controllers\LeadController::class, 'store'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);

    Route::delete('/sales/leads/{cabang}/leads/{id}', [\App\Http\Controllers\LeadController::class, 'destroy'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas'])
        ->name('sales.leads.destroy');
    
    Route::get('/sales/leads/{cabang}/leads/{id}/edit', [\App\Http\Controllers\LeadController::class, 'edit'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::put('/sales/leads/{cabang}/leads/{id}', [\App\Http\Controllers\LeadController::class, 'update'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);

    // SPV
    Route::get('/sales/leads/{cabang}/spv', [\App\Http\Controllers\SpvLeadController::class, 'index'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::get('/sales/leads/{cabang}/spv/create', [\App\Http\Controllers\SpvLeadController::class, 'create'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::post('/sales/leads/{cabang}/spv/store', [\App\Http\Controllers\SpvLeadController::class, 'store'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::delete('/sales/leads/{cabang}/spv/{id}', [\App\Http\Controllers\SpvLeadController::class, 'destroy'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::get('/sales/leads/{cabang}/spv/{id}/edit', [\App\Http\Controllers\SpvLeadController::class, 'edit'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::put('/sales/leads/{cabang}/spv/{id}', [\App\Http\Controllers\SpvLeadController::class, 'update'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);

    // Sales
    Route::get('/sales/leads/{cabang}/sales', [\App\Http\Controllers\SalesLeadController::class, 'index'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::get('/sales/leads/{cabang}/sales/create', [\App\Http\Controllers\SalesLeadController::class, 'create'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::post('/sales/leads/{cabang}/sales/store', [\App\Http\Controllers\SalesLeadController::class, 'store'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::delete('/sales/leads/{cabang}/sales/{id}', [\App\Http\Controllers\SalesLeadController::class, 'destroy'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::get('/sales/leads/{cabang}/sales/{id}/edit', [\App\Http\Controllers\SalesLeadController::class, 'edit'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::put('/sales/leads/{cabang}/sales/{id}', [\App\Http\Controllers\SalesLeadController::class, 'update'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);

    // ADM
    Route::get('/sales/leads/{cabang}/adm', [\App\Http\Controllers\AdmLeadController::class, 'index'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::get('/sales/leads/{cabang}/adm/create', [\App\Http\Controllers\AdmLeadController::class, 'create'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::post('/sales/leads/{cabang}/adm/store', [\App\Http\Controllers\AdmLeadController::class, 'store'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::delete('/sales/leads/{cabang}/adm/{id}', [\App\Http\Controllers\AdmLeadController::class, 'destroy'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::get('/sales/leads/{cabang}/adm/{id}/edit', [\App\Http\Controllers\AdmLeadController::class, 'edit'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);
    Route::put('/sales/leads/{cabang}/adm/{id}', [\App\Http\Controllers\AdmLeadController::class, 'update'])
        ->whereIn('cabang', ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas']);

    // Unit Lead
    Route::get('/sales/leads/unit', [\App\Http\Controllers\UnitLeadController::class, 'index']);
    Route::get('/sales/leads/unit/create', [\App\Http\Controllers\UnitLeadController::class, 'create']);
    Route::post('/sales/leads/unit', [\App\Http\Controllers\UnitLeadController::class, 'store']);
    Route::get('/sales/leads/unit/{unit}/edit', [\App\Http\Controllers\UnitLeadController::class, 'edit']);
    Route::put('/sales/leads/unit/{unit}', [\App\Http\Controllers\UnitLeadController::class, 'update']);
    Route::delete('/sales/leads/unit/{unit}', [\App\Http\Controllers\UnitLeadController::class, 'destroy']);

    // Sumber Lead
    Route::get('/sales/leads/sumber', [\App\Http\Controllers\SumberLeadController::class, 'index']);
    Route::get('/sales/leads/sumber/create', [\App\Http\Controllers\SumberLeadController::class, 'create']);
    Route::post('/sales/leads/sumber', [\App\Http\Controllers\SumberLeadController::class, 'store']);
    Route::get('/sales/leads/sumber/{sumber}/edit', [\App\Http\Controllers\SumberLeadController::class, 'edit']);
    Route::put('/sales/leads/sumber/{sumber}', [\App\Http\Controllers\SumberLeadController::class, 'update']);
    Route::delete('/sales/leads/sumber/{sumber}', [\App\Http\Controllers\SumberLeadController::class, 'destroy']);

    // Budget Lead
    Route::get('/sales/leads/budget', [\App\Http\Controllers\BudgetLeadController::class, 'index']);
    Route::get('/sales/leads/budget/create', [\App\Http\Controllers\BudgetLeadController::class, 'create']);
    Route::post('/sales/leads/budget', [\App\Http\Controllers\BudgetLeadController::class, 'store']);
    Route::get('/sales/leads/budget/{budget}/edit', [\App\Http\Controllers\BudgetLeadController::class, 'edit']);
    Route::put('/sales/leads/budget/{budget}', [\App\Http\Controllers\BudgetLeadController::class, 'update']);
    Route::delete('/sales/leads/budget/{budget}', [\App\Http\Controllers\BudgetLeadController::class, 'destroy']);

    // Status Lead
    Route::get('/sales/leads/status', [\App\Http\Controllers\StatusLeadController::class, 'index']);
    Route::get('/sales/leads/status/create', [\App\Http\Controllers\StatusLeadController::class, 'create']);
    Route::post('/sales/leads/status', [\App\Http\Controllers\StatusLeadController::class, 'store']);
    Route::get('/sales/leads/status/{status}/edit', [\App\Http\Controllers\StatusLeadController::class, 'edit']);
    Route::put('/sales/leads/status/{status}', [\App\Http\Controllers\StatusLeadController::class, 'update']);
    Route::delete('/sales/leads/status/{status}', [\App\Http\Controllers\StatusLeadController::class, 'destroy']);

    // Respon Lead
    Route::get('/sales/leads/respon', [\App\Http\Controllers\ResponLeadController::class, 'index']);
    Route::get('/sales/leads/respon/create', [\App\Http\Controllers\ResponLeadController::class, 'create']);
    Route::post('/sales/leads/respon', [\App\Http\Controllers\ResponLeadController::class, 'store']);
    Route::get('/sales/leads/respon/{respon}/edit', [\App\Http\Controllers\ResponLeadController::class, 'edit']);
    Route::put('/sales/leads/respon/{respon}', [\App\Http\Controllers\ResponLeadController::class, 'update']);
    Route::delete('/sales/leads/respon/{respon}', [\App\Http\Controllers\ResponLeadController::class, 'destroy']);

    // Route untuk PDF Post Check (sesuai request user)
    Route::get('/postcheck/pdf_laporan/{id}', [\App\Http\Controllers\Service\PostCheckAcController::class, 'pdf'])->name('postcheck.pdf_laporan');

    // Service AC
    Route::prefix('service/service-ac')->name('service.service-ac.')->group(function () {
        Route::get('/', [ServiceAcController::class, 'monitoring'])->name('index');
        Route::get('/monitoring', [ServiceAcController::class, 'monitoring'])->name('monitoring');
        
        // Post Check AC Routes
        Route::get('/ac/post-check', [PostCheckAcController::class, 'index'])->name('ac.post_check');
        Route::post('/ac/post-check', [PostCheckAcController::class, 'store'])->name('ac.post_check_store');
        Route::get('/ac/post-check/{id}/edit', [PostCheckAcController::class, 'edit'])->name('ac.post_check_edit');
        Route::put('/ac/post-check/{id}', [PostCheckAcController::class, 'update'])->name('ac.post_check_update');
        Route::patch('/ac/post-check/{id}/status', [PostCheckAcController::class, 'updateStatus'])->name('ac.post_check_status');
        Route::get('/ac/post-check/{id}/pdf', [PostCheckAcController::class, 'pdf'])->name('ac.post_check_pdf');
        Route::delete('/ac/post-check/{id}', [PostCheckAcController::class, 'destroy'])->name('ac.post_check_destroy');
        
        // Pre Check AC Routes
        Route::get('/ac/pre-check', [PreCheckAcController::class, 'index'])->name('ac.pre_check');
        Route::post('/ac/pre-check', [PreCheckAcController::class, 'store'])->name('ac.pre_check_store');
        Route::get('/ac/pre-check/{id}/edit', [PreCheckAcController::class, 'edit'])->name('ac.pre_check_edit');
        Route::put('/ac/pre-check/{id}', [PreCheckAcController::class, 'update'])->name('ac.pre_check_update');
        Route::patch('/ac/pre-check/{id}/status', [PreCheckAcController::class, 'updateStatus'])->name('ac.pre_check_status');
        Route::get('/ac/pre-check/{id}/pdf', [PreCheckAcController::class, 'pdf'])->name('ac.pre_check_pdf');
        Route::delete('/ac/pre-check/{id}', [PreCheckAcController::class, 'destroy'])->name('ac.pre_check_destroy');
        Route::resource('data', ServiceAcController::class)->parameters(['data' => 'data']);
    });

});

Route::fallback(function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
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
