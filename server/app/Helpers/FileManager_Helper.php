<?php
namespace App\Helpers;
use Illuminate\Support\Facades\File;

class FileManager{
    static function makeNewDirectory($request){
        if (! File::exists($request)) {
            File::makeDirectory($request);
        }
    }
}
