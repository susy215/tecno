<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductReportExport implements FromCollection,WithHeadings
{
    use Exportable;

    protected $start_date;
    protected $end_date;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
    public function headings(): array
    {
        return ['Code','Product Date', 'Product Name', 'Quantity', 'Cost', 'Selling Price','Discount','Total Cost', 'Total Price'  ];
    }

    public function collection()
    {
        $query = Product::select('id', 'created_date', 'title', 'qty', 'cost','price','discount','total_cost','total_price');
    if ($this->start_date && $this->end_date) {
        $query->whereBetween('created_date', [$this->start_date, $this->end_date]);
    }
    return $query->get();
        return Product::all();
    }
}
