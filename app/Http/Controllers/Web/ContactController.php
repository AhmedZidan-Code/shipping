<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('Web.contact');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|max:255',
            'subject' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Create a new contact record
        $contact = Contacts::create($validatedData);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'تم الارسال بنجاح',
        ]);
    }
}
