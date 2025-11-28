<?php
namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class PaymentExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $start_date;
    protected $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return ['OrderID','Name', 'Date', 'Payment Type', 'Delivery', 'Amount'];
    }

    public function collection()
    {
        $query = Payment::select('payments.order_id', 'users.name as created_by_name', 'payments.created_at', 'payments.type', 'payments.delivery', 'payments.amount')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->join('users', 'orders.created_by', '=', 'users.id');

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('payments.created_date', [$this->start_date, $this->end_date]);
        }

        return $query->get();
    }
}
