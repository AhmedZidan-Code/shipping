<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Slider;


class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $features = Feature::all();
        return view('Web.home', compact('sliders', 'features'));
    }
}
