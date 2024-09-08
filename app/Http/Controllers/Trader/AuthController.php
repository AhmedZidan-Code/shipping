<?php

namespace App\Http\Controllers\Trader;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload_Files;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use Upload_Files;

    public function loginView()
    {
        if (trader()->check())
            return redirect()->route('trader.index');
        return view('Trader.Auth.login');
    }//end fun
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(Request $request)
    {

        $data = $request->validate([
            'user_name' => 'required|exists:traders',
            'password' => 'required|min:6'
        ]);

        if (trader()->attempt($data))
            return response()->json(200);

        return response()->json(405);

    }//end fun
    public function logout()
    {
        trader()->logout();
        toastr()->info('logged out successfully');
        return redirect()->route('trader.login');
    }

    public function show( $id)
    {


        $trader=trader()->user();

        $html= view('Trader.profile.show', compact('trader'))->render();
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
            'user_name' => 'required|unique:traders,user_name,'.trader()->user()->id,
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
        $trader=trader()->user();

        if ($request->password) {

            $data['password']=bcrypt($request->password);

        } else {

            $data['password']=$trader->password;
        }
        if ($request->logo){
            $data["logo"] =  $this->uploadFiles('traders',$request->file('logo'),null );

        }
        $trader->update($data);



        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
                'name'=>$trader->name,
                'logo'=>get_file($trader->logo),

            ]);
    }


}//end class
