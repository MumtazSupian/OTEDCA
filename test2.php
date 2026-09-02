<?php
$nullCount = App\Models\Lead::whereNull('status_id')->count();
$eightCount = App\Models\Lead::where('status_id', 8)->count();
echo "Null status_id: $nullCount\n";
echo "Status_id 8: $eightCount\n";
