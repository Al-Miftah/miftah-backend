<?php 

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 * 
 */
trait UploadTrait {
    
    /**
     * Upload a file
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $filename
     * @return bool
     */
    public function upload(UploadedFile $file, string $folder = null, string $filename = null)
    {
        $name = $filename ??  Str::random(20).'.'.$file->getClientOriginalExtension();
        $folder = $folder ?? 'public/uploads';
        $options = [
            'visibility' => 'public'
        ];
        return Storage::putFileAs($folder, $file, $name, $options);
    }
}