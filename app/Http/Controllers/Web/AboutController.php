<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\StaticPage;
use App\Models\Statistics;

class AboutController extends Controller
{
    public function index()
    {
        $statistics = Statistics::where('page_id', 2)->get();
        $members = Member::all();
        $about = StaticPage::where('page_id', 2)->first();
        return view('Web.about', compact('statistics', 'members', 'about'));
    }
}
