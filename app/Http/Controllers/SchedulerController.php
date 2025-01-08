<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchedulerRequest;
use App\Http\Requests\UpdateSchedulerRequest;
use App\Models\Scheduler;
use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SchedulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where("id_user", Auth::user()->id_user)
        ->join('property', 'property.id_property', '=', 'tasks.id_property')
        ->join('rents', 'rents.id_rent', '=', 'tasks.id_rent')
        ->get()
        ->groupBy(function ($task) {
            return \Carbon\Carbon::parse($task->created_at)->format('D F Y');
        });
        return view('view.calendar', [
            "tasks" => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchedulerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function showTask(Request $request): View
    {

        return view('view.task');
    }

    /**
     * Display the specified resource.
     */
    public function showCalendar(Request $request)
    {
        return view('view.calendar');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scheduler $scheduler)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchedulerRequest $request, Scheduler $scheduler)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scheduler $scheduler)
    {
        //
    }
}
