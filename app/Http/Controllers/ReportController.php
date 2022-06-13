<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Invoice;

class ReportController extends Controller
{
    public function index()
    {
        return view('Reports.index');
    }

    public function search_invoices(Request $request)
    {
        $data = $request->validate([
            'type' => 'required',
        ],
        [
            'type.required' => 'حالة الفواتير مطلوبه',
        ]);

        $rdio = $request->rdio;

        if ($rdio == 1)
        {
            if ($request->type && $request->start_at == '' && $request->end_at == '')
            {
                $data['invoices'] = Invoice::select('*')->where('status', $request->type)->get();
                $type = $request->type;
                return view('Reports.index', compact('type'))->with($data);
            }
            else
            {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $data['invoices'] = Invoice::whereBetween('invoice_date', [$start_at, $end_at])->where('status', $request->type)->get();
                return view('Reports.index', compact('type', 'start_at', 'end_at'))->with($data);
            }
        }
        else
        {
            $data['invoices'] = Invoice::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('Reports.index')->with($data);
        }
    }

    public function category_index()
    {
        $data['categories'] = Category::all();
        return view('Reports.cat_index')->with($data);
    }

    public function search_categories(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
        ],
        [
            'category_id.required' => 'حقل القسم المحدد مطلوب ',
        ]);

        if($request->category_id && $request->product && $request->start_at == '' && $request->end_at == '')
        {
            $data['invoices'] = Invoice::select('*')->where('category_id', $request->category_id)->get();
            $data['categories'] = Category::all();
            return view('Reports.cat_index')->with($data);
        }
        else
        {
            $start_at = $request->start_at;
            $end_at   = $request->end_at;
            $data['categories'] = Category::all();
            $data['invoices'] = Invoice::whereBetween('invoice_date', [$start_at, $end_at])->where('category_id', $request->category_id)->get();
            return view('Reports.cat_index', compact('start_at', 'end_at'))->with($data);
        }
    }

    public function all_index()
    {
        $data['categories'] = Category::all();
        return view('Reports.all')->with($data);
    }

    public function search_all(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'type' => 'required'
        ],
        [
            'category_id.required' => 'حقل القسم المحدد مطلوب ',
            'type.required' => 'حقل تحديد نوع الفواتير مطلوب'
        ]);
        if($request->category_id && $request->product && $request->type && $request->start_at == '' && $request->end_at =='')
        {
            $type = $request->type;
            $data['categories'] = Category::all();
            $data['invoices'] = Invoice::select('*')->where([['category_id', $request->category_id],['status', $request->type]])->get();
            return view('Reports.all', compact('type'))->with($data);
        }
        else
        {
            $type     = $request->type;
            $start_at = $request->start_at;
            $end_at   = $request->end_at;
            $data['categories'] = Category::all();
            $data['invoices'] = Invoice::select('*')->whereBetween('invoice_date', [$start_at, $end_at])
            ->where([
                ['category_id', $request->category_id],
                ['status', $request->type],
                ])->get();
            return view('Reports.all', compact('type', 'start_at', 'end_at'))->with($data);
        }
    }
}
