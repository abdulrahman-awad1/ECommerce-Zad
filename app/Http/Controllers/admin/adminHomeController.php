<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminHomeController extends Controller
{
   
    public function sections(){
       
        $rooms = Room::get();
        return view('admin.sections',compact('rooms'));
    }

    

    public function category($category)
    {
        $rooms = Room::with('images')
            ->where('category_id', $category)
            ->get();
    
        return view('admin.category', compact('rooms'));
    }

    // public function contact(){
    //     return view('contact');
    // }

    // public function bedrooms()
    // {
    //     $rooms = Room::with('images')
    //         ->where('category_name', 'غرف نوم')
    //         ->get();

    //    return view('bedrooms', compact('rooms'));
    // }

    // public function children_rooms()
    // {
    //     $rooms = Room::with('images')
    //         ->where('category_name', 'غرف اطفال')
    //         ->get();

    //     return view('children_rooms', compact('rooms'));
    // }

    // public function salon()
    // {
    //     $rooms = Room::with('images')
    //         ->where('category_name', 'صالون')
    //         ->get();

    //     return view('salon', compact('rooms'));
    // }

    // public function sofra()
    // {
    //     $rooms = Room::with(['images','category'])
    //         ->where('category_id', 4)
    //         ->get();

    //     return view('sofra', compact('rooms'));
    // }

   




}


