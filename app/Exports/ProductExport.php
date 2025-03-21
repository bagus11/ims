<?php

namespace App\Exports;

use App\Models\Master\ProductModel;
use App\Models\PrductModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return collect($this->products)->map(function ($product) {
            
            return [
                'Product Code' => $product['product_code'],
                'Name' => $product['name'],
                'Category' => $product['category_id'] ?? '',
                'Location' => $product['location_id'] ?? '',
                'Quantity Before' => $product['quantity_before'], // Tambahkan Quantity Sebelum Update
                'Quantity After' => $product['quantity_after'],   // Tambahkan Quantity Setelah Update
            ];
        });
    }

    public function headings(): array
    {
        return ['Product Code', 'Name', 'Category', 'Location', 'Quantity Before','Quantity'];
    }    
}
