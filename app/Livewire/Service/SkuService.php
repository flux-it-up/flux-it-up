<?php

namespace App\Livewire\Service;

use App\Models\Service;
use App\Models\Console;
use Illuminate\Support\Facades\DB;

class SkuService
{
    public function generateServiceConsoleSku(Service $service, $console, float $priceAdjustment = 0)
    {
        $sku = $service->generateServiceConsoleSku($console);

        $service->consoles()->syncWithoutDetaching([
            $console->id => [
                'price_adjustment' => $priceAdjustment,
                'sku' => $sku,
                'updated_at' => now()
            ]
        ]);

        return $sku;
    }

    public function generateBulkServiceConsoleSku(Service $service, array $consoleData)
    {
        $skus = [];

        DB::transaction(function () use ($service, $consoleData, &$skus) {
            foreach ($consoleData as $data) {
                $console = Console::find($data['console_id']);
                $priceAdjustment = $data['price_adjustment'] ?? 0;

                if ($console) {
                    $sku = $this->generateServiceConsoleSku($service, $console, $priceAdjustment);
                    $skus[] = [
                        'console_id' => $console->id,
                        'console_name' => $console->name,
                        'sku' => $sku
                    ];
                }
            }
        });

        return $skus;
    }

    public function getServiceSkus(Service $service)
    {
        $skus = [
            'base_sku' => $service->sku,
            'console_skus' => []
        ];

        foreach ($service->consoles as $console) {
            $skus['console_skus'][] = [
                'console_id' => $console->id,
                'console_name' => $console->name,
                'console_code' => $console->code,
                'sku' => $console->pivot->sku,
                'price_adjustment' => $console->pivot->price_adjustment
            ];
        }

        return $skus;
    }
}
