<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Str;
use App\Models\Console;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

trait GeneratesSku
{
    public function generatesProductSku()
    {
        $categoryId = $this->category_id;
        $categoryName = ProductCategory::find($categoryId);
        
        $category = strtoupper(substr($categoryName->name, 0, 3));
        $code = strtoupper($this->code);
        $timestamp = now()->format('ymd');
        
        $baseSku = "PROD-{$category}-{$code}-{$timestamp}";
        
        return $this->ensureUniqueSku($baseSku, 'products');
    }

    public function generatesServiceSku()
    {
        $category = strtoupper(substr($this->category->name, 0, 3));
        $code = strtoupper($this->code);
        $timestamp = now()->format('ymd');
        
        $baseSku = "SRV-{$category}-{$code}-{$timestamp}";
        
        return $this->ensureUniqueSku($baseSku, 'services');
    }

    /**
     * Generate SKU for service-console combination
     */
    public function generateServiceConsoleSku($console): string
    {
        $serviceCode = strtoupper($this->code);
        $consoleCode = strtoupper($console->code);
        $category = strtoupper(substr($this->category, 0, 3));
        $timestamp = now()->format('ymd');
        
        $baseSku = "SRV-{$category}-{$serviceCode}-{$consoleCode}-{$timestamp}";
        
        return $this->ensureUniqueSku($baseSku, 'console_service');
    }

    /**
     * Ensure SKU uniqueness by adding incremental suffix if needed
     */
    private function ensureUniqueSku(string $baseSku, string $table): string
    {
        $sku = $baseSku;
        $counter = 1;

        while ($this->skuExists($sku, $table)) {
            $sku = $baseSku . '-' . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $counter++;
        }

        return $sku;
    }

    /**
     * Check if SKU exists in the specified table
     */
    private function skuExists(string $sku, string $table): bool
    {
        return \DB::table($table)->where('sku', $sku)->exists();
    }
}
