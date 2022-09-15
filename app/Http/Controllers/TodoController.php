<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    //

    public function index(){
        try {

            $all_todos = Todo::all();

            return BaseController::success('All todo list', $all_todos);

        }
        catch (Exception $e){
            return BaseController::error('Something went wrong.');
        }
    }
    
    public function create(Request $request){
        try {

            $validator =  Validator::make($request->all(), [
                // 'driver_user_id' => 'required|integer',
                'title' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = new Todo();
            $todo->title = $request->title;
            $todo->note = isset($request->note) ? $request->note : null ;
            $todo->start_date =  Carbon::parse($request->start_date)->format('Y-m-d');
            $todo->end_date =  Carbon::parse($request->end_date)->format('Y-m-d');
            $todo->start_time =  Carbon::parse($request->start_time)->format('H:i');
            $todo->end_time =  Carbon::parse($request->end_time)->format('H:i');

            $todo->save();
            $all_todos = Todo::all();
            return BaseController::success('New todo added', $all_todos);

        }
        catch (Exception $e){
            return $e;
            return BaseController::error('Something went wrong.');
        }
    }

    public function update(Request $request){
        try {

            $validator =  Validator::make($request->all(), [
                // 'driver_user_id' => 'required|integer',
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = Todo::find($request->id);
            if(!$todo) return BaseController::error('Todo not found');

            $todo->title =  isset($request->title) ? $request->title : $todo->title;
            $todo->note = isset($request->note) ? $request->note : $todo->note ;
            $todo->start_date =  isset($request->start_date) ? Carbon::parse($request->start_date)->format('Y-m-d') : $todo->start_date;
            $todo->end_date =  isset($request->end_date) ? Carbon::parse($request->end_date)->format('Y-m-d') : $todo->end_date;
            $todo->start_time =  isset($request->start_time) ? Carbon::parse($request->start_time)->format('H:i') : $todo->start_time;
            $todo->end_time =  isset($request->end_time) ? Carbon::parse($request->end_time)->format('H:i') : $todo->end_time;

            $todo->save();
            $all_todos = Todo::all();
            return BaseController::success('Updated successfully', $all_todos);

        }
        catch (Exception $e){
            return BaseController::error('Something went wrong.');
        }
    }

    public function delete(Request $request){
        try {

            $validator =  Validator::make($request->all(), [
                // 'driver_user_id' => 'required|integer',
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = Todo::find($request->id);
            if(!$todo) return BaseController::error('Todo not found');

            $todo->delete();
            $all_todos = Todo::all();
            return BaseController::success('Deleted successfully', $all_todos);

        }
        catch (Exception $e){
            
            return BaseController::error('Something went wrong.');
        }
    }
    
    public function toggle(Request $request){
        try {

            $validator =  Validator::make($request->all(), [
                // 'driver_user_id' => 'required|integer',
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = Todo::find($request->id);
            if(!$todo) return BaseController::error('Todo not found');

            if($todo->is_completed == false){
                $todo->is_completed = true;
                $todo->save();
            }
            else {
                return BaseController::error('This todo already completed');
            }
            $all_todos = Todo::all();
            return BaseController::success('Todo marked as completed', $all_todos);

        }
        catch (Exception $e){
            return BaseController::error('Something went wrong.');
        }
    }


}
