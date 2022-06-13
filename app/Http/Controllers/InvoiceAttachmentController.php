<?php

namespace App\Http\Controllers;

use App\Invoice_Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'file_name'         => 'required|mimes:jpg,jpeg,png,pdf,docx,pptx',
        ],
        [
            'file_name.mimes' => 'المرفق يجب ان يكون من صيغة pdf, jpeg,png,jpg,pptx',
        ]);

        $data['added_by'] = Auth::user()->name ;
        $data['invoice_id'] = $request->invoice_id ;
        $data['invoice_number'] = $request->invoice_number ;

        // $saved = $request->file('file_name');
        // $savedFile = $saved->getClientOriginalName();
        // $saved->storeAs('Attachment', $savedFile);
        // Save The Files Uploaded From The Same Author within a Collective Folder As Line 58
        // Only what it changed id the methode saveAs instead of using The move methode in a public path
        // $saved->storeAs('Attachment/'.auth()->user()->id (The Folder), $savedFile);

        $savedImage = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachment/'.$request->invoice_number), $savedImage);
        $data['file_name'] = $savedImage ;

        Invoice_Attachments::create($data);
        session()->flash('success', 'تم اضافة المرفق بنجاح') ;
        return back();
    }
}
