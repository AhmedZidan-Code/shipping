<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{

    public function showLoginForm()
    {
        return view('Web.auth.login');

    }
    public function login(Request $request)
    {
        $data = $request->validate([
            'user_name' => 'required|exists:traders,user_name',
            'password' => 'required',
        ]);

        if (trader()->attempt($data)) {
            return response()->json([
                'status' => 'success',
                'message' => 'مرحباً بك في منصتك ' . trader()->user()->name,
                'redirect_url' => route('trader.index'),
            ], 201);

        }

        return response()->json([
            'status' => 'error',
            'message' => 'بيانات الدخول غير صحيحة',
        ], 405);

    }
    public function showRegistrationForm()
    {
        $categories = Category::get();
        return view('Web.auth.register', compact('categories'));
    }
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required|string|unique:traders,phone',
            'user_name' => 'required|email|unique:traders,user_name',
            'password' => ['required', Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(), 'confirmed'],
            'category_id' => 'required|exists:categories,id',
            'terms_and_conditions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create trader
        $trader = Trader::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'user_name' => $request->user_name,
            'password' => bcrypt($request->password),
            'category_id' => $request->category_id,
            'trader_type' => 2,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم التسجيل بنجاح',
            'redirect_url' => route('web.login'),
        ], 201);
    }

    public function logout()
    {
        trader()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الخروج بنجاح',
            'redirect_url' => route('web.login'),
        ], 201);

    }
}
