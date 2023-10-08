<?php

namespace App\Trait;

Trait HttpResponses{
    protected function success($data, $message=null, $code=200){
        return response()->json([
            'success' => true,
           'error'   => null,
           'body'    => $data,
        ], $code);
    }

    protected function error($data, $error, $message=null, $code){
        return response()->json([
            'success' => false,
           'error'   => $error,
           'body'    => null,
        ], $code);
    }
}