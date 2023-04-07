<?php

namespace App\Http\Controllers;

use App\Models\system_mang;
use Illuminate\Http\Request;

class SystemMangControl extends Controller
{
    public function index()
    {
        // echo "fuck";
        $system = system_mang::all();
        return view('frontInvoices.index_system', compact('system'));
    }

    public function store(Request $request)
    {
        $validtiondata = $request->validate(
            [
                'logo_name' => 'required|max:255',
                'phone' => 'required',
                'email' => 'required',
                'logo_photo' => 'mimes:jpeg,png,jpg'
            ],
            [
                'logo_name.required' => 'يرجى ادخال اسم الشركة',
                'phone.required' => 'يرجى ادخال رقم هاتف الشركة',
                'email.required' => 'يرجى ادخال البريد الإلكتروني للشركة',
                'logo_photo.mimes' => 'صيغة المرفق يجب ان تكون  , jpeg , png , jpg',

            ]
        );
        // 
        $sys = new system_mang();
        if ($request->hasFile('logo_photo')) {

            $image = $request->file('logo_photo');
            $file_name = $image->getClientOriginalName();
            $sys->logo_photo = $file_name;
            $sys->logo_name = $request->logo_name;
            $sys->phone = $request->phone;
            $sys->email = $request->email;
            $sys->save();

            $imageName = $request->logo_photo->getClientOriginalName();
            $request->logo_photo->move(public_path('Attachments/'), $imageName);
        }

        //   die($sys);
        session()->flash('Add', 'تم اضافة البيانات بنجاح');
        return redirect('/mange_system');
    }

    public function update(Request $request)
    {

        $this->validate(
            $request,
            [

                'logo_name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'logo_photo' => 'required',
            ],
            [
                'logo_name.required' => 'يرجى ادخال اسم الشركة',
                'phone.required' => 'يرجى ادخال رقم هاتف الشركة',
                'email.required' => 'يرجى ادخال البريد الإلكتروني للشركة',
                'logo_photo.mimes' => 'صيغة المرفق يجب ان تكون  , jpeg , png , jpg',

            ]
        );
        $id = $request->id;
        $logo_name = $request->logo_name;
        $phone = $request->phone;
        $email = $request->email;



        $old_image = system_mang::find($id);

        $image_name = $request->logo_photo;
        $image = $request->file('logo_photo');
        if($image != '')
        {
            $image_name = rand().'.'.$image->getClientOriginalName();
            $image->move(public_path('Attachments/'),$image_name);
            unlink('Attachments/'.$old_image->logo_photo);
        }
        $update = [
            'logo_name' => $logo_name,
            'phone' => $phone,
            'email' => $email,
            'logo_photo' => $image_name
        ];
   system_mang::where('id',$request->id)->update($update);
            session()->flash('Edit', 'تم تعديل البياات بنجاج');
            return redirect('/mange_system');
        }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Products = system_mang::findOrFail($request->pro_id);
        unlink('Attachments/'.$Products->logo_photo);
        $Products->delete();
        session()->flash('delete', 'تم حذف البيانات بنجاح');
        return back();
    }
}
