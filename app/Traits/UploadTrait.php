<?php 

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
trait UploadTrait {
    /**
     * 
     */
    public function upload(UploadedFile $file, $folder = null, $filename = null, $disk = null)
    {
        $name = $filename ??  Str::random(20).'.'.$file->getClientOriginalExtension();
        $folder = $folder ?? 'public/uploads';
        return $file->storeAs($folder, $name);
    }
}