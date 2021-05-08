<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;

class MessageController extends Controller
{
    public function send()
    {
        return response()->json(['data' => 'seems to work']);
    }
}
