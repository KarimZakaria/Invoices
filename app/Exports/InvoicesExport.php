<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesExport implements FromView
{
    public function view(): View
    {
        return view('Invoices.exports', [
            'invoices' => Invoice::withTrashed()->get()
        ]);
    }
}
