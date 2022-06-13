<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image ;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->id == $id)
        {
            $data['profile'] = User::findOrFail($id);
            return view('users.profile')->with($data);
        }
        else
        {
            session()->flash('success', "غير مسموح لك بزيارة هذا الملف");
            return back();
        }
    }

    public function edit($id)
    {
        if(Auth::user()->id == $id)
        {
            $data['user'] = User::findOrFail($id);
            return view('users.editProfile')->with($data);
        }
        else
        {
            session()->flash('success', "غير مسموح لك بزيارة هذا الملف");
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->id == $id)
        {
            $data = $request->validate([
                'name'  => 'required|min:4|max:30',
                'email' => 'required|email',
                'image' => 'nullable|mimes:jpg,png,jpeg,gif'
            ]);
            $old_image = User::findOrFail($id)->image;

            if($request->hasFile('image'))
            {
                Storage::disk('image_uploads')->delete('images/'. $old_image);
                // $new_image_name = $request->image->getClientOriginalName();
                // $request->image->move(public_path('Profile/images/'. $new_image_name), $new_image_name);
                // $data['image'] = $new_image_name ;

                $new_image_name = $data['image']->hashName();
                Image::make($data['image'])->resize(690 , 520)->save(public_path('Profile/images/'. $new_image_name));
                $data['image'] = $new_image_name;
            }
            else
            {
                $data['image'] = $old_image;
            }
            $user = User::findOrFail($id);
            $user->update($data);
            session()->flash('success', 'تم تحديث البيانات بنجاح');
            return back();
        }
    }
}
