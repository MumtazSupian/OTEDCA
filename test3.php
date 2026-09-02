<?php
$allStatuses = App\Models\StatusLead::all();
$noReportStatusId = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'no report') !== false; })->pluck('id')->first();
echo "No Report Status ID: " . var_export($noReportStatusId, true) . "\n";
