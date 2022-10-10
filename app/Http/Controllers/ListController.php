<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListFormRequest;
use App\Mail\AddListEmail;
use App\Mail\DeleteListEmail;
use App\Models\Roll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{

    public function index()
    {
        return view('dashboard');
    }


    public function create()
    {
        return view('addList');
    }


    public function store(Request $request)
    {
        try {

            $request->validate([
                'list_name' => 'required|string|min:3|max:60|unique:lists'
            ]);
            $userEmail = auth()->user()->email;
            $list = new Roll;

            $list->user_id = auth()->user()->id;
            $list->list_name = $request->list_name;

            $list->save();
            $mailData = [
                'title' => 'List added',
                'body' => 'List ' . $list->list_name . ' added successfully'
            ];
            Mail::to($userEmail)->send(new AddListEmail($mailData));

            return back()->with('success', 'List added successfully');

        } catch (\Exception $e) {

            return back()->with($e->getMessage());
        }


    }

    public function show(Request $request)
    {
        try {
            $userID = auth()->user()->id;

            $lists = DB::table('lists')->where('user_id', $userID)->get();

            return view('dashboard', ['lists' => $lists]);

        } catch (\Exception $e) {

            return back()->with($e->getMessage());
        }

    }

    public function edit($id)
    {
        try {

            $list = Roll::find($id);
            return view('editList', compact('list'));

        } catch (\Exception $e) {

            return back()->with($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'list_name' => 'required|string|min:3|max:60|unique:lists'
            ]);
            $newListName = $request->list_name;
            Roll::find($id)->update(['list_name' => $newListName]);
            return back()->with('success', 'List name changed successfully');

        } catch (\Exception $e) {

            return back()->with($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $listName = DB::table('lists')->where('id', $id)->value('list_name');;
            Roll::find($id)->delete();

            $mailData = [
                'title' => 'List deleted',
                'body' => 'List ' . $listName . ' deleted successfully'
            ];

            Mail::to(auth()->user()->email)->send(new DeleteListEmail($mailData));
            return back()->with('success', 'List deleted successfully');

        } catch (\Exception $e) {

            return back()->with($e->getMessage());
        }

    }
}
