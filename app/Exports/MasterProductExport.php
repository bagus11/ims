<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterProductExport implements FromCollection,WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Transform data for Excel
        return $this->data->map(function ($item) {
            return [
                'product_code' => $item->product_code,
                'name' => $item->name,
                'category' => $item->categoryRelation->name ?? '',
                'location' => $item->locationRelation->name ?? '',
                'quanity' => $item->quantity ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Product Code',
            'Name',
            'Category',
            'Location',
            'Quantity',
        ];
    }
}
