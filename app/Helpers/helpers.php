<?php

use Illuminate\Support\Facades\Storage;


if (! function_exists('successMessageWithData')) {
    function successMessageWithData($message = null, $data = null)
    {
        return response()->json([
            'status'    => true,
            'message'   => $message,
            'data'      => $data
        ]);
    }
}

if (! function_exists('errorMessage')) {
    function errorMessage($message, $code = 400)
    {
        return response()->json([
            'status'  => false,
            'message'     => $message,
        ], $code);
    }
}

if(! function_exists('successMessage')){
    function successMessage($message)
    {
        return response()->json([
            'status'    => true,
            'message'   => $message,
        ]);
    }
}

if (! function_exists('uploadFile')) {
    function uploadFile($file, $path)
    {
        $ext = $file->extension();
        $imageName = date('Y-m-d') . '_' . uniqid() . '.' . $ext;
        $pathUrl = $file->storeAs($path, $imageName);

        return $pathUrl;
    }
}

if (! function_exists('deletFile')) {
    function deletFile($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}

