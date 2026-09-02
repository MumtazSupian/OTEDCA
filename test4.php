<?php
$request = new Illuminate\Http\Request();
$controller = new App\Http\Controllers\Sales\LeadsDashboardController();
$view = $controller->index($request);
$data = $view->getData();
echo "No Report Count: " . $data['noReportCount'] . "\n";
echo "No Report ID: " . App\Models\StatusLead::all()->filter(function($s) { return stripos($s->nama_status, 'no report') !== false; })->pluck('id')->first() . "\n";
echo "Leads Where ID 8: " . App\Models\Lead::get()->where('status_id', 8)->count() . "\n";
echo "Leads Where ID NULL: " . App\Models\Lead::get()->whereNull('status_id')->count() . "\n";
