<?php

namespace App\Http\Controllers;
use App\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['paidInvoices']   = Invoice::sum('total');
        $data['weeklyInvoices'] = Invoice::whereBetween('invoice_date', ['2021-02-26', '2021-03-03'])->get();
        $data['weeklyPaid']     = Invoice::where('status_value', 1)->whereBetween('updated_at', ['2021-04-09' , '2021-04-17'])->get();
        $data['weeklyUnPaid']   = Invoice::where('status_value', 2)->whereBetween('updated_at', ['2021-04-09' , '2021-04-17'])->get();
        $data['partialPaid']    = Invoice::where('status_value', 3)->whereBetween('updated_at', ['2021-04-09' , '2021-04-17'])->get();
        $all = Invoice::count();
        $paid = Invoice::where('status_value', 1)->count();
        $unpaid = Invoice::where('status_value', 2)->count();
        $partialpaid = Invoice::where('status_value', 3)->count();

        $data['lastFiveInvoices'] = Invoice::orderBy('id', 'DESC')->take(5)->get();

        // Start PIE Chart With Pie Precentage of all Invoices
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 200, 'height' => 100])
            ->datasets([
            [
                "label" => "المدفوعة",
                'backgroundColor' => ['blue'],
                'data' => [$paid]
            ],
            [
                "label" => "المدفوعة جزئيا",
                'backgroundColor' => ['orange'],
                'data' => [$partialpaid]
            ],
            [
                "label" => "غير المدفوعة",
                'backgroundColor' => ['red'],
                'data' => [$unpaid]
            ],
        ])
        ->options([]);


        // Satrt Circle Chart With circle Precentge of all Invoices.
        $chartjs2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 255])
        ->labels(['المدفوعة كليا', 'غير المدفوعة',  'المدفوع جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['blue', 'red', 'orange'],
                'hoverBackgroundColor' => ['blue', 'red', 'orange'],
                'data' => [$paid, $unpaid, $partialpaid]
            ]
        ])
        ->options([]);

        return view('home', compact('chartjs', 'chartjs2'))->with($data);
    }
}
