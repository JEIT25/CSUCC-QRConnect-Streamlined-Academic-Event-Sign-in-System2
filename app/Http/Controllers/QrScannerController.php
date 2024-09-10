<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrScannerController extends Controller
{
    public function checkin() {
        return inertia('QrScanner/Checkin');
    }

    public function checkout()
    {
        return inertia('QrScanner/Checkin');
    }
}
