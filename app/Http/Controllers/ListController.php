<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListFormRequest;
use App\Models\Roll;
use Illuminate\Http\Request;
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
        $request->validate([
            'list_name' => 'required|string|min:3|max:60|unique:lists'
        ]);

        $list=new Roll;

        $list->user_id = auth()->user()->id;
        $list->list_name = $request->list_name;

        $list->save();

        return back()->with('success','List added successfully');

    }

    public function show(Request $request)
    {
       $userID=auth()->user()->id;

       $lists=DB::table('lists')->where('user_id',$userID)->get();

       return view('dashboard',['lists' => $lists]);

    }

    public function edit($id)
    {
        $list=Roll::find($id);
        return view('editList',compact('list'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'list_name' => 'required|string|min:3|max:60|unique:lists'
            ]);
            $newListName=$request->list_name;
            Roll::find($id)->update(['list_name' => $newListName]);
            return back()->with('success','List name changed successfully');

        }catch(Exception $e) {

            return back()->with($e->getMessage());
        }
    }

    public function destroy($id)
    {
        Roll::find($id)->delete();
        return back()->with('success','List deleted successfully');
    }
}
