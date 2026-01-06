<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\RoomService;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;


class HomeController extends Controller
{
    public function home(RoomService $service)
{
    $data = $service->homeData();

    if (Auth::check() && Auth::user()->role === 'admin') {
        $rooms = Room::get();
        return view('admin.dashboard', compact('rooms'));
    }

    return view(Auth::check() ? 'user.home' : 'user.guest', $data);
}


    public function contact()
{
    return view('user.contact');
}

public function sections(RoomService $service)
{
    $data = $service->homeData();
    return view('user.sections',$data);
}


    
}


