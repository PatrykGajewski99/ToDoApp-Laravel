<?php

namespace App\Http\Controllers;

use App\Models\Roll;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomePageController extends Controller
{
    public function show()
    {
        try {
            $lists = DB::table('lists')->get();

            return view('welcome', ['lists' => $lists]);

        } catch (\Exception $e) {

        return view('welcome')->with('error', 'Something was wrong');
        }
    }
    public function showTask($listID)
    {
        try {
            $tasks=DB::table('tasks')->where('list_id',$listID)->get();
            return view('task',['tasks' => $tasks]);

        }catch (\Exception $e) {

            return view('welcome')->with('error', 'Something was wrong');
        }
    }
}
