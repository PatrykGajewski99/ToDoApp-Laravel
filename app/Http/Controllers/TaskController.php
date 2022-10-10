<?php

namespace App\Http\Controllers;

use App\Mail\AddTaskEmail;
use App\Mail\DeleteTaskEmail;
use App\Mail\UpdateTaskEmail;
use App\Models\Roll;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class TaskController extends Controller
{
    private function checkTaskName(string $taskName,int $userID) : bool
    {
        $userTasksName=DB::table('tasks')->where('user_id',$userID)->get('task_name');
        foreach ($userTasksName as $userTaskName)
        {
            $name=$userTaskName->task_name;
            if($name === $taskName)
                return false;
        }
        return true;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $listID = $id;
        return view('addTask', compact('listID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        try {
            $request->validate([
                'task_name' => 'required|string|min:3|max:256'
            ]);

            $task = new Task;

            $task->user_id = auth()->user()->id;
            $task->list_id = $id;
            $task->task_name = $request->task_name;
            $task->status = "to-do";
            if($this->checkTaskName($task->task_name,auth()->user()->id))
            {
                $task->save();

                $mailData = [
                    'title' => 'Task added',
                    'body' => 'Task ' . $task->task_name . ' added successfully'
                ];
                Mail::to(auth()->user()->email)->send(new AddTaskEmail($mailData));

                return back()->with('success', 'Task added successfully');
            }
            else
            {
                return back()->with('error', 'Task not added successfully. Name is not unique');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Something was wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $userID = auth()->user()->id;
            $listID = $id;

            $tasks = DB::table('tasks')->where([['user_id', $userID], ['list_id', $listID]])->get();

            return view('showTasks', ['tasks' => $tasks]);

        } catch (\Exception $e) {

            return back()->with('error', 'Something was wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $task = Task::find($id);
            return view('editTask', compact('task'));

        } catch (\Exception $e) {

            return back()->with('error', 'Something was wrong');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'task_name' => 'required|string|min:3|max:256'
            ]);
            $data = $request->all();
            $task_name = $request->input('task_name');
            $userID = auth()->user()->id;

            $userEmail = DB::table('users')->where('id', $userID)->value('email');
            Task::find($id)->update($data);
            $mailData = [
                'title' => 'Updated task',
                'body' => 'Task ' . $task_name . ' updated successfully'
                ];
            Mail::to($userEmail)->send(new UpdateTaskEmail($mailData));
            return back()->with('success', 'Task changed successfully');

        } catch (\Exception $e) {

            return back()->with('error', 'Something was wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $taskName = DB::table('tasks')->where('id', $id)->value('task_name');;
            Task::find($id)->delete();

            $mailData = [
                'title' => 'Task deleted',
                'body' => 'Task ' . $taskName . ' deleted successfully'
            ];

            Mail::to(auth()->user()->email)->send(new DeleteTaskEmail($mailData));

            return back()->with('success', 'Task deleted successfully');

        } catch (\Exception $e) {

            return back()->with('error', 'Something was wrong');
        }

    }
}
