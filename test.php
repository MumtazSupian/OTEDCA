<?php
$id = App\Models\StatusLead::all()->filter(function($s) { return stripos($s->nama_status, 'no report') !== false; })->pluck('id')->first();
echo "ID: " . json_encode($id) . "\n";
