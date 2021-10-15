<?php
use Illuminate\Support\Facades\File;

function makeNewDirectory($request){
    if (! File::exists($request)) {
        File::makeDirectory($request);
    }
}

function deleteDirectory($request){
    if (! File::exists($request)) {
        File::unlink($request);
    }
}
