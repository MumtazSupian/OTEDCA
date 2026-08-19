<?php

namespace Tests\Unit;

use Tests\TestCase;

class ComposerAutoloadTest extends TestCase
{
    public function test_legacy_sales_classes_are_resolvable(): void
    {
        $this->assertTrue(class_exists(\App\Http\Controllers\Sales\StockController::class));
        $this->assertTrue(class_exists(\App\Models\Sales\Cabang::class));
        $this->assertTrue(class_exists(\App\Exports\StockExport::class));
    }
}
