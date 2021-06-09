<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class IconController extends Controller{

    public function listIcons() {
        
        $icons = $json = Storage::disk('local')->get('/public/icons/icons.json');
        $icons = json_decode($icons, true);
        return $icons;
    }
}
