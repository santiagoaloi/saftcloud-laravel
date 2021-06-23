<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class IconController extends Controller{

    public function listIcons() {
        $icons = Storage::disk('local')->get('/public/icons/icons.json');
        $icons = json_decode($icons, true);
        return $icons;
    }
}
