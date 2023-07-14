<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\PusherBroadcast;

class PusherController extends Controller
{
    public function index()
    {
        return view('index', ['channel' => Str::random(6)]);
    }

    public function broadcast(Request $request)
    {
        broadcast(new PusherBroadcast($request->get('message'), $request->channel))->toOthers();

        return view('broadcast', ['message' => $request->get('message')]);
    }

    public function receive(Request $request)
    {
        return view('receive', ['message' => $request->get('message')]);
    }
}
