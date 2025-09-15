<?php
namespace App\Helpers;
use Illuminate\Http\UploadFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadManager{

    public static function uploadFile($file, $file_path=null ){
        $file_path=$file_path ?? 'images/'.(auth()->id ?? ''). '/';
        $original_filename = $file->getClientOriginalName();
        $original_filename_arr= explode('.',$original_filename);
        $file_name = $original_filename[0];
        $file_ext= strtoLower(end($original_filename_arr));
        $file_path_name=time().'_'.Str::slug(pathinfo($original_filename, PATHINFO_FILENAME)).'.'.$file_ext;

        if(Storage::put($file_path.$file_path_name, file_get_contents($file))){
            $relative_path = $file_path.$file_path_name;
        }
        else{
            $relative_path=null;
        }
        return[
            'origianl_doc_name'=> $original_filename,
            'doc_name'=>$file_path_name,
            'path'=>$relative_path,
            'slug'=>Str::slug($file_name).'.'.$file_ext,
            'doc_type'=>$file_ext,
        ];
    }
}



