<?php

namespace App\Http\Controllers;

use App\ImageUpload;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function index()
    {
        return view('image_upload');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $image = $request->file('file');
        $imagename = $image->getClientOriginalName();
        $image->move(public_path('image'), $imagename);

        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imagename;
        $imageUpload->save();

        return response()->json(['success' => $imagename]);
    }


    public function destory(Request $request)
    {
        
        $filename = $request->get('filename');
        ImageUpload::where('filename', $filename)->delete();
        $path = public_path().'/image/'.$filename;

        if(file_exists($path)){
            unlink($path);
        }

        return $filename;
    }
}
