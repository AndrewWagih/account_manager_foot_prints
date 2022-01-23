<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountManagerAction;
use App\Models\AccountManagerLog;
use Illuminate\Validation\Rule;
use Validator;
class ActionController extends Controller
{

    public function index(){
        $actions = AccountManagerAction::get()->map(function($row){
            $row->data = $row->data !=null ? unserialize($row->data):[];
            return $row;
        });
        return response()->json([
            'data' => $actions
        ], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'action_type' => 'required|in:index,create,store,edit,update,delete',
            'actionable_type'=>'required',
            'actionable_id' => 'required',
            'data' => ['required_if:action_type,create,store,edit,update,delete'],
            'log_id' => ['required',Rule::in(AccountManagerLog::pluck('id'))]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }
        $action = new AccountManagerAction();
        $action->action_type = $request->action_type;
        $action->actionable_type = $request->actionable_type;
        $action->actionable_id = $request->actionable_id;
        if($request->data !=null){
            $action->data = serialize($request->data);
        }
        $action->log_id = $request->log_id;
        $action->save();
        return response()->json([
            'data' => $action,
            'data unserialize' => unserialize($action->data)
        ], 200);
        
    }
}
