<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Process;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Statistics;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $features = Feature::all();
        $services = Service::all();
        $processes = Process::all();
        $statistics = Statistics::where('page_id', 1)->get();
        $video = Video::where('page_id', 1)->first();
        return view('Web.home', compact('sliders', 'features', 'services', 'processes', 'statistics', 'video'));
    }
}
