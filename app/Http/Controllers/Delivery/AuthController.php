<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload_Files;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use Upload_Files;

    public function loginView()
    {
        if (delivery()->check())
            return redirect()->route('delivery.index');
        return view('Delivery.Auth.login');
    }//end fun
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(Request $request)
    {


        $data = $request->validate([
            'user_name' => 'required|exists:deliveries,user_name',
            'password' => 'required|min:6'
        ]);

        if (delivery()->attempt($data))
            return response()->json(200);

        return response()->json(405);

    }//end fun
    public function logout()
    {
        delivery()->logout();
        toastr()->info('logged out successfully');
        return redirect()->route('delivery.login');
    }

    public function show( $id)
    {


        $delivery=delivery()->user();

        $html= view('Delivery.profile.show', compact('delivery'))->render();
        return response()->json([
            'code'=>200,
            'html'=>$html,
        ]);

        //
    }

    public function update(Request $request,  $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'user_name' => 'required|unique:deliveries,user_name,'.delivery()->user()->id,
            'password' => 'nullable',
            'logo'=>'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif',
            'phone' => 'required',
        ],[
            'name.required'=>'الاسم مطلوب',
            'email.required'=>'البريد الالكتروني مطلوب',
            'email.email'=>'البريد الالكتروني غير صحيح',
            'email.unique'=>'البريد الالكتروني  موجود مسبقا',
            'password.required'=>' الرقم السري مطلوب',
            'phone.required'=>' رقم الهاتف مطلوب',
            'logo.required'=>' صورة التاجر مطلوبة',
            'logo.mimes'=>' صورة التاجر لابد ان تكون صورة',
        ]);
        $delivery=delivery()->user();

        if ($request->password) {

            $data['password']=bcrypt($request->password);

        } else {

            $data['password']=$delivery->password;
        }
        if ($request->logo){
            $data["logo"] =  $this->uploadFiles('deliveries',$request->file('logo'),null );

        }
        $delivery->update($data);



        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
                'name'=>$delivery->name,
                'logo'=>get_file($delivery->logo),

            ]);
    }


}//end class
