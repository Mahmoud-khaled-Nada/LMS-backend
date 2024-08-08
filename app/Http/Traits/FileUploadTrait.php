<?php

namespace App\Http\Traits;
use Image;


trait FileUploadTrait
{
   public function upload($file,$folder){
         $image = time() . '.' . str_replace(" ", "", $file->getClientOriginalName());
         $image_file = Image::make($file)->save(public_path($folder.$image));
         //$image_file->save(public_path($folder).$image);
        return $image;
   }
}
