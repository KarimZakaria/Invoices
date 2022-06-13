<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /*** Display a listing of the resource.
    *
    **
    @return \Illuminate\Http\Response
    */
    function __construct()
    {
        $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
        $this->middleware('permission:اضافة صلاحية', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل صلاحية', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    }
    /*
    ** Display a listing of the resource.
    *
    **
    @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /*
    *
    * Show the form for creating a new resource.**
    @return \Illuminate\Http\Response
    */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }
    /*
    ** Store a newly created resource in storage.**
    @param  \Illuminate\Http\Request  $request*
    @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        // $this->validate(
        //     $request, [
        //         'name' => 'required|unique:roles,name',
        //         'permission' => 'required'
        //     ]);
        // $role = Role::create(['name' => $request->input('name')]);
        // $role->syncPermissions($request->input('permission'));
        // return redirect()->route('roles.index')->with('success', 'تم حفظ الصلاحية بنجاح');

        $data = $request->validate([
            'name' => 'required',
            'permission' => 'required'
        ]);
        $role = Role::create(['name' => $data['name']]);
        $role->syncPermissions($data['permission']);
        session()->flash('success', 'تم حفظ الصلاحية بنجاح');
        return redirect(route('roles.index'));
    }
    /*
    ** Display the specified resource.*
    * @param  int  $id
    *
    @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $id)->get();
        return view('roles.show', compact('role', 'rolePermissions'));
    }
    /*
    ** Show the form for editing the specified resource.
    *
    * @param  int  $id
    *
    @return \Illuminate\Http\Response*/
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }
    /*
    ** Update the specified resource in storage.
    ** @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request, [
                'name' => 'required',
                'permission' => 'required'
            ],
            [
                'name.required' => 'هذا الحقل مطلوب',
                'permission.required' => 'حقل الصلاحية مطلوب'
            ]);
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')->with('success', 'تم تحيث الصلاحية بنجاح');
    }
    /*
    ** Remove the specified resource from storage.
    ** @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'تم حذف الصلاحية بنجاح');
    }
}
