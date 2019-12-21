<?php 

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
trait UploadTrait {
    /**
     * 
     */
    public function upload(UploadedFile $file, $folder = null, $filename = null)
    {
        $name = $filename ??  Str::random(20).'.'.$file->getClientOriginalExtension();
        $folder = $folder ?? 'public/uploads';
        $options = [
            'visibility' => 'public'
        ];
        return Storage::putFileAs($folder, $file, $name, $options);
        //return $file->storeAs($folder, $name);
    }
}