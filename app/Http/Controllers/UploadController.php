<?php

namespace App\Http\Controllers;

use App\Libraries\ImageKit;
use Illuminate\Http\Request;


class UploadController extends Controller
{
    public function index()
    {
    }

    public function upload(Request $request){
        $file = $request->file('file');
        $upload = new ImageKit();
        $res =  $upload->uploadFile($file, 'images');
        return [$res['url']];
    }

}
