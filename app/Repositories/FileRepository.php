<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class FileRepository
{

    public function uploadFile($file, $path, $driver = 'local')
    {
        if (!Storage::has($path)) {
            Storage::makeDirectory($path, 0777, true);
        }
        $uploadedFile = $file->storeAs(
            'public/'.$path,
            $file->hashName(),
            $driver
        );
        return Storage::url($uploadedFile);
    }

}
