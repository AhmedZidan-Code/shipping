<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use Upload_Files,LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض الإعدادت العامة')->only(['index']);
        $this->middleware('permission:تعديل الإعدادت العامة')->only(['Store']);

    }




    public function index()
    {

        $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الاعدادات العامة");

        $settings = Setting::firstOrNew();
        return view('Admin.settings.index', [
            'settings' => $settings,
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $data = $request->validate([

            'app_name'=>'nullable',
            'governorate'=>'nullable',
            'phones'=>'nullable',
            'email'=>'nullable',
            'address'=>'nullable',
            'lat'=>'nullable',
            'lng'=>'nullable',
            'facebook'=>'nullable',
            'twitter'=>'nullable',
            'linkedin'=>'nullable',
            'youtube'=>'nullable',
            'terms_and_condition'=>'nullable',
            'privacy_policy'=>'nullable',
            'legal'=>'nullable',
            'logo_header'=>'nullable|image',
            'logo_footer'=>'nullable|image',
            'fave_icon'=>'nullable|image',

        ],
        [

        ]
        );

        if ($request->logo_header)
        $data['logo_header'] =  $this->uploadFiles('settings',$request->file('logo_header'),null );

        if ($request->logo_footer)
            $data['logo_footer'] =  $this->uploadFiles('settings',$request->file('logo_footer'),null );

        if ($request->fave_icon)
            $data['fave_icon'] =  $this->uploadFiles('settings',$request->file('fave_icon'),null );


        $setting=Setting::firstOrNew();

        $old=$setting;
         $setting->update($data);

        $this->add_log_activity($old,auth('admin')->user(),"تم تعديل الاعدادات العامة ");



        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);

    }


}
