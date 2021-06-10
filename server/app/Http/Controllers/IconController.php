<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Facades\Storage;


class IconController extends Controller{

    public function listIcons() {
        $icons = Storage::disk('local')->get('/public/icons/icons.json');
        $icons = json_decode($icons, true);
        return $icons;
    }
}
