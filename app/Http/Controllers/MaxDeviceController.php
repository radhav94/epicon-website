<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaxDeviceController extends Controller
{
    
    public function maxDevice(Request $request)
    {
        $activeDeviceArr = CurlAPI("users/getDevice", 'POST', [], 2, true, true);
        if (!$activeDeviceArr) {
            return view('pages.error.data-error');
        }
        $activeDevices = @$activeDeviceArr['success'] && array_key_exists('data', $activeDeviceArr) ? $activeDeviceArr['data'] : [];

        
        if (count($activeDevices) <= 5) {
            session()->forget('maxDevice');
            return redirect('/');
        }
        // dd($activeDevices);
        return view('settings.max-device', compact('activeDevices'));
    }
}
