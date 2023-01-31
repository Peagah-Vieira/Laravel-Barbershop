<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function show()
    {
        $category = Category::all();
        $barber = User::all();

        return view('index', [
            'categories' => $category,
            'barbers' => $barber
        ]);
    }

    public function store(Request $request)
    {
        $event = new Event();
        $event->subject = $request->subject;
        $event->body = $request->body;
        $event->category = $request->category;
        $event->participants = [1];
        $event->start = $request->start;
        $event->startTime = $request->startTime;
        $event->end = now();
        $event->endTime = now();
        $event->created_at = now();
        $event->updated_at = now();
        $event->save();

        return redirect('/admin');
    }
}
