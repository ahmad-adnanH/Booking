<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // 1. استدعاء
abstract class Controller
{
    use AuthorizesRequests; 
}
