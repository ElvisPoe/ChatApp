<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use Illuminate\Support\Facades\Crypt;

class MessagesController extends Controller
{
    public function index()
    {
        return view('messages.index', ['channel' => Str::random(6)]);
    }

    public function newRoom()
    {
        $newRoomLink = app('url')->previous() . '?' . http_build_query(['channel' => Str::random(6)]);
        
        return redirect()->to($newRoomLink);
    }

    public function broadcast(Request $request)
    {
        $message = Crypt::encryptString($request->get('message'));

        broadcast(new PusherBroadcast($message))->toOthers();

        return view('messages.broadcast', ['message' => Crypt::decryptString($message)]);
    }

    public function receive(Request $request)
    {
        return view('messages.receive', ['message' => Crypt::decryptString($request->get('message'))]);
    }
}
