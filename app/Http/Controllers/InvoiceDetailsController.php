<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Invoice_Attachments;
use App\Invoice_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
    public function details($id)
    {
        $data['invoice']     = Invoice::findOrFail($id);
        $data['details']     = Invoice_Details::where('invoice_id', $id)->get();
        $data['attachments'] = Invoice_Attachments::where('invoice_id', $id)->orderBy('id', 'DESC')->get();

        return view('Invoices.details')->with($data);
    }

    public function open_file($invoice_number, $file_name)
    {
        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
        return response()->file($file);
    }

    public function download($invoice_number, $file_name)
    {
        $download = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
        return response()->download($download);
    }

    public function destroy(Request $request)
    {
        $file = Invoice_Attachments::findOrFail($request->file_id);
        $file->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('success', 'تم حذف المرفق بنجاح');
        return back();
    }
}
