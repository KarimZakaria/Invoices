<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\InvoicesExport;
use App\Invoice;
use App\Invoice_Attachments;
use App\Invoice_Details;
use App\Notifications\AddingInvoice;
use App\Notifications\NewInvoiceAdded;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['partial_paid_invoices']]);
    }

    public function index()
    {
        $data['invoices'] = Invoice::all();
        return view('Invoices.index')->with($data);
    }

    public function user_invoices($id)
    {
        if(Auth::user()->roles_name == '["Owner"]')
        {
            $data['invoices'] = Invoice::all();
            return view('Invoices.index')->with($data);
        }
        else
        {
            $user = User::find($id);
            if(Auth::user()->id == $id)
            {
                $data['invoices'] = $user->invoice()->get();
                return view('Invoices.index')->with($data);
            }
            else
            {
                session()->flash('success', "غير مسموح لك بزيارة هذا الرابط");
                return back();
            }
        }
    }

    public function create()
    {
        $data['categories'] = Category::all();
        return view('Invoices.create')->with($data);
    }

    public function store(Request $request)
    {
        $data =$request->validate(
            [
                'category_id'       => 'required',
                'invoice_number'    => 'required|integer|unique:invoices',
                'invoice_date'      => 'required',
                'due_date'          => 'required',
                'product'           => 'required',
                'Amount_collection' => 'required|integer|min:10|max:1000000',
                'Amount_Commission' => 'required|integer|min:10|max:1000000',
                'discount'          => 'required|integer',
                'rat_vat'           => 'required',
                'vat_value'         => 'required',
                'total'             => 'required',
                'note'              => 'nullable|max:1000'
            ],
            [
                'category_id.required'      => 'حقل القسم التابع للفاتوره مطلوب',
                'invoice_number.required'   => 'رقم الفاتوره مطلوب',
                'invoice_number.unique'     => 'رقم الفاتوره موجود مسبقا بالفعل',
                'invoice_number.integer'    => 'رقم الفاتوره يجب ان يكون أرقام فقط',
                'due_date.required'         => 'تاريخ الفاتوره مطلوب',
                'product.required'          => 'المنتج الخاص بالفاتوره مطلوب',
                'Amount_Commission.required' => 'حقل مبلغ التحصيل مطلوب',
                'Amount_collection.required' => 'حقل مبلغ العمولة مطلوب',
                'discount.required'         => 'حقل الخصم مطلوب',
                'rat_vat'                   => 'حقل نسبة ضريبه القيمة المضافه مطلوب',
            ]
        );
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'غير مدفوعه';
        $data['status_value'] = 2;

        Invoice::create($data);

        // Start Entering Data Into Invoice Details
        $invoice_id = Invoice::latest()->first()->id;

        $data = $request->validate([
            'invoice_number'    => 'required',
            'product'           => 'required',
            'category_id'       => 'required',
            'notes'             => 'nullable',
        ]);

        $data['invoice_id'] = $invoice_id;
        $data['user'] = Auth::user()->name;
        $data['status'] = 'غير مدفوعه';
        $data['status_value'] = 2;

        Invoice_Details::create($data);

        // Start Attachments Data Entering
        $invoice_id = Invoice::latest()->first()->id;

        $data = $request->validate([
            'invoice_number'    => 'required|integer',
            'file_name'         => 'required|mimes:jpg,png,jpeg,docx,pdf,pptx'
        ]);

        $data['invoice_id'] = $invoice_id;
        $data['added_by']   = Auth::user()->name;
        $invoice_name       = $data['invoice_number'];

        if ($request->hasFile('file_name')) {
            $savedImage = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachment/' . $invoice_name), $savedImage);
        }
        $data['file_name'] = $savedImage;

        Invoice_Attachments::create($data);

        // Send Mail
        // $mailedUser = User::all();
        // Notification::send($mailedUser, new AddingInvoice($invoice_id));

        // View Notification
        $notificatedUser = User::where('roles_name','["Owner"]')->get();
        Notification::send($notificatedUser, new NewInvoiceAdded($invoice_id));

        session()->flash('success', 'تم اضافة الفاتورة بنجاح');
        return redirect(route('invoices.index'));
    }

    public function show($id)
    {
        $data['invoice'] = Invoice::findOrFail($id);
        $data['categories'] = Category::all();
        return view('Invoices.payment_status')->with($data);
    }

    public function update_status(Request $request, $id)
    {
        if($request->status == 'مدفوعة')
        {
            $data = $request->validate([
                'status'        => 'required',
                'Payment_date'  => 'required'
            ]);
            $data['status_value'] = 1 ;

            Invoice::findOrFail($id)->update($data);

            $dataDetails['Payment_date'] = $request->Payment_date;
            $dataDetails['status_value'] = 1 ;
            $dataDetails['status'] = 'مدفوعة';

            Invoice_Details::where('invoice_id', $id)->update($dataDetails);
            session()->flash('success', 'تم تعديل حاله الدفع الي فاتوره مدفوعه');
            return redirect(route('invoices.index'));
        }
        else
        {
            $data = $request->validate([
                'status'        => 'required',
                'Payment_date'  => 'required'
            ]);
            $data['status_value'] = 3 ;

            Invoice::findOrFail($id)->update($data);

            $dataDetails['Payment_date'] = $request->Payment_date;
            $dataDetails['status_value'] = 3 ;
            $dataDetails['status'] = 'مدفوعة جزئيا';

            Invoice_Details::where('invoice_id', $id)->update($dataDetails);
            session()->flash('success', 'تم تعديل حاله الدفع الي فاتوره مدفوعه جزئيا');
            return redirect(route('invoices.index'));
        }
    }

    public function edit($id)
    {
        $data['invoice']    = Invoice::findOrFail($id);
        $data['categories'] = Category::all();
        return view('Invoices.edit')->with($data);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'category_id'       => 'required',
            'invoice_number'    => 'required|numeric',
            'invoice_date'      => 'required',
            'due_date'          => 'required',
            'product'           => 'required',
            'Amount_collection' => 'required|numeric|min:10|max:1000000',
            'Amount_Commission' => 'required|numeric|min:10|max:1000000',
            'discount'          => 'required',
            'rat_vat'           => 'required',
            'vat_value'         => 'required',
            'total'             => 'required',
            'note'              => 'nullable|max:1000'
        ],
        [
            'category_id.required'      => 'حقل القسم التابع للفاتوره مطلوب',
            'invoice_number.required'   => 'رقم الفاتوره مطلوب',
            'invoice_number.integer'    => 'رقم الفاتوره يجب ان يكون أرقام فقط',
            'due_date.required'         => 'تاريخ الفاتوره مطلوب',
            'product.required'          => 'المنتج الخاص بالفاتوره مطلوب',
            'Amount_Commission.required' => 'حقل مبلغ التحصيل مطلوب',
            'Amount_collection.required' => 'حقل مبلغ العمولة مطلوب',
            'discount.required'         => 'حقل الخصم مطلوب',
            'rat_vat'                   => 'حقل نسبة ضريبه القيمة المضافه مطلوب',
        ]);

        Invoice::findOrFail($request->id)->update($data);
        session()->flash('success', 'تم تعديل الفاتوره بنجاح');
        return back();

    }

    public function destroy($id)
    {
        $invoice    = Invoice::withTrashed()->findOrFail($id);
        $attachments= Invoice_Attachments::where('invoice_id', $id)->first();

        if($invoice->trashed())
        {
            $invoice->forceDelete();
            Storage::disk('public_uploads')->deleteDirectory($attachments->invoice_number);
            session()->flash('success', 'تم حذف الفاتورة نهائيا بنجاح');
            return redirect(route('invoices.index'));
        }
        else
        {
            $invoice->delete();
            session()->flash('success', 'تم حذف الفاتوره جزئيا من المشهد ولكن لازالت موجوده ف جدول البيبانات');
            return redirect(route('invoices.index'));
        }

    }

    public function trashed()
    {
        $data['invoices'] = Invoice::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('invoices.trashed')->with($data);
    }

    public function restore($id)
    {
        Invoice::onlyTrashed()->findOrFail($id)->restore();
        session()->flash('success', 'تم استرجاع الفاتوره بنجاح للعرض');
        return redirect(route('invoices.index'));
    }

    public function getproducts($id)
    {
        /*
            get into products table where the selected category_id equals the id comes from request and get
            the product id and product_name which then used at ajax code to select it from the comed Category
            then return data as json encode so then convert it to decode and use it dynamically .
            pluck() method is one of laravel collection which works with the arrays to get any data from it
        */
        $products = DB::table("products")->where("category_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }

    public function paid_invoices()
    {
        $data['invoices'] = Invoice::where('status_value', 1)->get();
        return view('Invoices.paid')->with($data);
    }

    public function unpaid_invoices()
    {
        $data['invoices'] = Invoice::where('status_value', 2)->get();
        return view('Invoices.unpaid')->with($data);
    }

    public function partial_paid_invoices()
    {
        $data['invoices'] = Invoice::where('status_value', 3)->get();
        return view('Invoices.partial_paid')->with($data);
    }

    public function print_invoice($id)
    {
        $data['invoice'] = Invoice::findOrFail($id);
        return view('Invoices.print')->with($data);
    }

    // Start Excel Sheet Download
    public function export()
    {
        return Excel::download(new InvoicesExport, 'users.xlsx');
    }
}
