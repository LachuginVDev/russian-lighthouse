<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\SettingResource;
use App\Models\SiteSetting;

class SettingController extends Controller
{
    public function __invoke(): SettingResource
    {
        return new SettingResource(SiteSetting::current());
    }
}
