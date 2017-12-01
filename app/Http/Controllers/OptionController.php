<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;
use DB;
use Validator;

class OptionController extends Controller
{
    //
    public function showOptionPage()
    {
      $data = array(
        'title' => Option::getOptionValue('title'),
        'logo' => Option::getOptionValue('logo-text'),
        'description' => Option::getOptionValue('description'),
        'banner_title' => Option::getOptionValue('banner-title'),
        'banner_sub_title' => Option::getOptionValue('banner-sub-title'),
        'color_theme' => Option::getOptionValue('color-theme'),
        'colors' => DB::table('colors')->get()
      );
      return view('admin.settings')->with($data);
    }

    public function saveOption(Request $req)
    {
      Option::setOptionValue('title', $req->title);
      Option::setOptionValue('logo-text', $req->logo);
      Option::setOptionValue('description', $req->description);
      Option::setOptionValue('banner-title', $req->banner_title);
      Option::setOptionValue('banner-sub-title', $req->banner_sub_title);
      if(isset($req->banner_image)){
        Validator::make($req->all(),[
            'banner_image' => 'image'
          ])->validate();
        $path = $req->file('banner_image')->storeAs('public', 'banner.jpg');
      }
      Option::setOptionValue('color-theme', $req->colortheme);

      return redirect()->back()->with('status', 'Settings Saved');
    }
}
