<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function __construct()
    {
    }

    public static function upload($file, $directory, $fileName = null)
    {
        $uploadedFile = Storage::putFile($directory, $file, 'public');
        return $uploadedFile;
    }

    public static function delete($file)
    {
        return Storage::delete($file);
    }

    public static function download($path)
    {
        return Storage::download($path);
    }
}
