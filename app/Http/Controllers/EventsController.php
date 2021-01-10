<?php

/**
 * Events Controller 
 * 
 * @author: John Dave Lagdameo <jdlagdameo@gmail.com>
 * @since: 2021/01/08
 * @internal revisions: 
 * + 
 * 
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $events = Event::all();
        $success = $events? true: false;
        $message = "Event list successfully retrieved"; 
        $data = $events;

        return response()->json(compact("success", "message", "data"));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'eventName' => ['required', 'min:5', 'max:30'],
            'startDate' => ['required', 'date'],
            'endDate'   => ['required', 'date', 'after_or_equal:startDate'],
            'days'      => ['required'],
        ]);

        if($validator->fails()){
            $success = false;
            $message = "Failed to create new event.";
            $validation = $validator->messages();
            return response()->json(compact("success", "message", "validation"), 200);
        }

        $event_name = filter_var(trim($request->eventName), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $start_date = filter_var(trim($request->startDate), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $end_date   = filter_var(trim($request->endDate), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $days       = implode(", ", $request->days);

        $event = Event::create(compact("event_name", "start_date", "end_date", "days"));

        $success = $event ? true : false;
        $message = $success ? "Event successfully saved." : "Failed to create new event. Please try again.";

        return response()->json(compact("success", "message"));

    }


}
