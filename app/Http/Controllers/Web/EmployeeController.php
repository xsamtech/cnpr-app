<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();

        $this->middleware('auth');
    }

    // ==================================== HTTP GET METHODS ====================================

    // ==================================== HTTP POST METHODS ====================================
}
