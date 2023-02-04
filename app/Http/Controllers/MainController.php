<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
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
        $event->number = $request->number;
        $event->category = $request->category;
        $event->participants = [1];
        $event->organizer = 1;
        $event->start = $request->start;
        $event->startTime = $request->startTime;
        $event->end = Carbon::create($request->startTime)->addHour(1);
        $event->endTime = Carbon::create($request->startTime)->addHour(1);
        $event->created_at = now();
        $event->updated_at = now();
        $event->save();

        $payment = new Payment();
        $payment->fullname = $request->subject;
        $payment->category_id = $request->category;
        $payment->paid = 0;
        $payment->save();

        return redirect('/admin');
    }
}
