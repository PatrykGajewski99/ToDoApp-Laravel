<?php

namespace App\Http\Controllers;

use App\Models\Roll;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TaskController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $listID=$id;
        return view('addTask',compact('listID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $request->validate([
            'task_name' => 'required|string|min:3|max:256'
        ]);

        $task=new Task;

        $task->user_id = auth()->user()->id;
        $task->list_id=$id;
        $task->task_name = $request->task_name;
        $task->status="to-do";

        $task->save();

        return back()->with('success','Task added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userID=auth()->user()->id;
        $listID=$id;

        $tasks=DB::table('tasks')->where([['user_id',$userID],['list_id',$listID]])->get();

        return view('showTasks',['tasks' => $tasks]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task=Task::find($id);
        return view('editTask',compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'task_name' => 'required|string|min:3|max:256'
            ]);
            $data=$request->all();
            Task::find($id)->update($data);
            return back()->with('success','Task changed successfully');

        }catch(Exception $e) {

            return back()->with($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();
        return back()->with('success','Task deleted successfully');
    }
}
