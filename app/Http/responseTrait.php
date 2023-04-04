<?php

namespace App\Http;

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
}
