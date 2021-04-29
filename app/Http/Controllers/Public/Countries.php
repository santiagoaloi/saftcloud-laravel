<?php

namespace App\Http\Controllers\Public;
use App\Models\Public\Country;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Countries extends Controller {
    public function getCountries() {
        $query = Country::get();

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'data' => $query]);
        exit();
    }
}
