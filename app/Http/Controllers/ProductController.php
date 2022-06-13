<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::orderBy('id' , 'DESC')->get();
        $data['categories'] = Category::all();
        return view('Products.index')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|max:50|min:3' ,
            'description'  => 'nullable|min:10',
            'price'        => 'required|numeric',
            // Foreign Key Validation
            'category_id'  => 'required',
        ],
        [
            'product_name.required' => ' اسم المنتج مطلوب' ,
            'product_name.max'      => 'اسم المنتج يجب الا يزيد عن 50 أحرف' ,
            'product_name.min'      => 'اسم المنتج يجب الا يقل عن 3 أحرف' ,
            'description.min'       => 'وصف المنتج يجب الا يقل عن 10 أحرف',
            'price.required'        => 'حقل سعر المنتج مطلوب' ,
            'price.numeric'         => 'السعر يجب ان يكون محتوي علي اراقم فقط' ,
            'category_id.required'  => 'حقل القسم مطلوب اختياره',
        ]);

        Product::create($data) ;
        session()->flash('success' , 'تمت اضافة المنتج بنجاح');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Category::where('category_name', $request->category_name)->first()->id;

        $product = Product::findOrFail($request->id);

        $product->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price'     => $request->price ,
            'category_id' => $id
        ]);

        session()->flash('success', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if($product->trashed())
        {
            $product->forceDelete();
            session()->flash('success' , 'تم حذف المنتج نهائيا بنجاح');
            return back();
        }
        else
        {
            $product->delete();
            session()->flash('success' , 'تم حذف المنتج بنجاح');
            return back();
        }
    }

    public function trashed()
    {
        $data['categories'] = Category::all();
        $data['products'] = Product::onlyTrashed()->orderBy('id' , 'DESC')->get();
        return view('products.trashed')->with($data);
    }

    public function restore($id)
    {
        Product::onlyTrashed()->findOrFail($id)->restore();
        session()->flash('success' , 'تم استرجاع المنتج بنجاح');
        return redirect(route('products.index'));
    }
}
