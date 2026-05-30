<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TipResource;
use App\Models\Tip;

class TipController extends Controller
{
    public function index()
    {
        $tips = Tip::with('user')->latest()->get();
        return TipResource::collection($tips);
    }
}