<?php

namespace App\Http\Traits;


trait FileUpload
{
    public function uploadImage($file, $filename, $folder)
    {
        $file->move(public_path($folder), $filename);

        return $filename;
    }
}
