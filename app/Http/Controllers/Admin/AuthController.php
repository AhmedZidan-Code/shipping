<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function loginView()
    {
        if (admin()->check())
            return redirect()->route('admin.index');
        return view('Admin.Auth.login');
    } //end fun
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(Request $request)
    {

        
        $data = $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|min:6',
            'year' => 'required|in:2024,2025'
        ]);
        Session::put('year', $data['year']);

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];
        if (admin()->attempt($credentials))
        return response()->json(200);

        return response()->json(405);
    } //end fun
    public function logout()
    {
        Session::remove('year');
        admin()->logout();
        toastr()->info('logged out successfully');
        return redirect()->route('admin.login');
    }
}//end class
