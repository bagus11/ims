<?php

namespace App\Exports;

use App\Models\Master\ProductModel as MasterProductModel;
use App\Models\ProductModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExportTemplate implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $location;
    protected $category;

    public function __construct($location, $category)
    {
        $this->location = $location;
        $this->category = $category;
    }
    public function headings(): array
    {
        return [
            'Product Code',
            'Name',
            'Category',
            'Location',
            'Quantity',
            'Quantity Adjust',
        ];
    }

    public function collection()
    {
        return MasterProductModel::with(['categoryRelation', 'locationRelation'])
           ->where('location_id', $this->location)
           ->where('category_id', $this->category)
            ->get()
            ->map(function ($product) {
                return [
                    'product_code'      => $product->product_code,
                    'name'              => $product->name,
                    'category_name'     => $product->categoryRelation->name ?? '',
                    'location_name'     => $product->locationRelation->name ?? '',
                    'quantity'          => $product->quantity,
                    'quantity_adjust'   => '', // Kosongan
                ];
            });
    }
    public function columnWidths(): array
    {
        return [
            'A' => 20,  // Product Code
            'B' => 40,  // Name
            'C' => 20,  // Category
            'D' => 20,  // Location
            'E' => 10,   // Quantity
            'F' => 10,   // Quantity Adjust
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header Style (Baris 1)
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], // Warna teks putih
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '00879E'], // Warna header
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}

