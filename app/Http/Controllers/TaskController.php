<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoretaskRequest;
use App\Http\Requests\UpdatetaskRequest;
use App\Models\Resident;
use App\Models\task;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('id_user', Auth::id())->get();
        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    public function get(Request $request) {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;

        $getTask = task::select(
            'tasks.id_task',
            DB::raw("CONCAT(contact_information.first_name, ' ', contact_information.last_name) as full_name"),
            'task_name',
            'tasks.id_user',
            'task_desc',
            'property.property_name',
            'rents.rent_name',
            'rents.id_rent'
        )
            ->join('contact_information', 'tasks.id_user', '=', 'contact_information.id_user')
            ->join('property', 'tasks.id_property', '=', 'property.id_property')
            ->join('rents', 'tasks.id_rent', '=', 'rents.id_rent')
            ->when($filter, function ($query, $search) {
                $query->where('full_name', 'like', "%{$search}%")
                ->where('task_name', 'like', "%{$search}%")
                ->where('task_desc', 'like', "%{$search}%")
                ->where('property_name', 'like', "%{$search}%")
                ->where('rent_name', 'like', "%{$search}%");;
            })
            // ->when($groupBy, function ($query, $groupBy) {
            //     $query->groupBy($groupBy)
            // });
            ->when($request->orderBy, function ($query) use ($request) {
                $orderBy = $request->orderBy;
                $query->orderBy($orderBy, 'desc');
            })
            ->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Task",
            "data" => $getTask,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretaskRequest $request)
    {
        $request->validate(rules: [
            'task_name' => ['required', 'string', 'max:255'],
            'task_desc' => ['required', 'string'],
            'id_property' => ['required', 'numeric', 'max:11', 'exists:property,id_property'], 
            'id_rent' => ['required', 'numeric', 'max:11', 'exists:rents,id_rent'], 
            'id_user' => ['required', 'numeric', 'max:11', 'exists:users,id_user'], 
        ]);

        $getResident = Resident::where("id_rent", $request->id_rent)->where("id_user", $request->id_user)->first();

        if ($getResident) {
            $tasks = Task::create([
                'id_user' => Auth::user()->id_user,
                'task_name' => $request->task_name,
                'task_desc' => $request->task_desc,
                'id_property' => $request->id_property,
                'id_rent' => $request->id_rent,
                'id_user' => $request->id_user,
            ]);
    
            if ($request->header('Accept') === 'application/json') {
                return response()->json([
                    "success" => true,
                    "message" => "Berhasil menambah data Task",
                ], 200);
            } else {
                session()->flash('alert', [
                    'type' => 'success',
                    'message' => 'Task Created',
                ]);
                return redirect()->back();
            }
        } else {
            if ($request->header('Accept') === 'application/json') {
                return response()->json([
                    "success" => true,
                    "message" => "Gagal menambah data Task",
                ], 200);
            } else {
                session()->flash('alert', [
                    'type' => 'success',
                    'message' => 'Task Failed to Create',
                ]);
                return redirect()->back();
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(task $task): View
    {
        if ($task->id_user != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(task $task)
    {
        if ($task->id_user != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetaskRequest $request, task $task, $id)
    {
        $request->validate(rules: [
            'task_name' => ['required', 'string', 'max:255'],
            'task_desc' => ['required', 'string'],
            'id_user' => ['required', 'numeric', 'max:11', 'exists:users,id_user'], 
        ]);

        $task = Task::findOrFail($id);

        $task->task_name = $request->task_name;
        $task->task_desc = $request->task_desc;
        $task->id_user = $request->id_user;
        $task->save();

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil mengubah data Task",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Task Updated',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menghapus data Task",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Task Deleted',
            ]);
            return redirect()->back();
        }
    }
}
