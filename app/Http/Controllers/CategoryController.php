<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Category::select('id', 'category_name', 'description' , 'created_by')
        ->orderBy('id' , 'DESC')->get();
        return view('Category.index')->with($data);
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
            'category_name' => 'required|unique:categories|max:30|min:5',
            'description'   => 'nullable|min:10',
        ],
            // New Technology For Entering Validation Errors On any Language
            [
                'category_name.required' => 'هذا الحقل مطلوب',
                'category_name.unique'   => 'هذا الاسم موجود من قبل فعليا ' ,
                'description.min'   => 'حقل الوصف لا يجب ان يكون اقل من 10 حروف'
        ]);
            $data['created_by'] = Auth::user()->name;

            Category::create($data);
            session()->flash('success' , 'تمت اضافة القسم بنجاح');
            return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['category'] = Category::findOrFail($id);
        return view('Category.show')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Get id to ensure that the id can be not changed
        $id = $request->id ;
        $data = $request->validate([
            'category_name' => 'required|min:5|unique:categories,category_name,'.$id,
            'description'   => 'nullable|min:10',
        ] ,
        [
            'category_name.required' => 'هذا الحقل مطلوب ' ,
            'category_name.unique'   => 'هذا الاسم موجود مسبقا يرجي ادخال اسم اخر' ,
            'description.min'        => 'يجب الا يقل هذا الحقل عن عشرو احرف'
        ]);

        Category::findOrFail($request->id)->update($data);
        session()->flash('success' , 'تم تعديل القسم بنجاح ') ;
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        session()->flash('success' , 'تم حذف القسم بنجاح') ;
        return redirect()->route('categories.index');
    }
}
