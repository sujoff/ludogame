<?php

namespace App\Http\Controllers;

use App\Settings\ServerIpSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function ip(ServerIpSetting $settings){
        return [
            'primary' => [
                'ip' => $settings->primary,
                'enable' => (bool) $settings->primary_enable,
            ],
            'secondary' => [
                'ip' => $settings->secondary,
                'enable' => (bool) $settings->secondary_enable,
            ]
        ];
    }
}
