<?php

namespace App\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;


trait responseTrait
{
    public function response($data=null,$message=null,$status=null){
        $array=[
            'data'=>$data,
            'message'=>$message,
            'status'=>$status
        ];
        return response($array);
    }
    public function uploadFile(Request $request,$folderName,$fileName){
        if($request->hasFile($fileName)&& $request->$fileName != Null){
            $path = $request->file($fileName)->store($folderName,'custom');
            return $path;
        }
        return Null;
    }
    public function uploadMultiFile(Request $request,$i,$folderName,$fileName){
        if($request->hasfile($fileName)&& $request->$fileName[$i] != Null ){
            $path = $request->file($fileName)[$i]->store($folderName,'custom');
                return $path;
            }
            return Null;
        }
    public function getFile($path){
        return response()->file(storage_path($path));
    }
    public function deleteFile($path){
        if (file_exists(storage_path($path))) {
            return File::delete(storage_path($path));
        }
       // if(Storage::exists($path)){
       //     Storage::delete($path);
       // }
        return null;//apiResponse(401,'',"File doesn't exists");
    }

}
