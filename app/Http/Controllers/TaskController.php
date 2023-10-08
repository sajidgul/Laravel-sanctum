<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TasksResource;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TasksResource::collection(
            Task::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'description'=>'required',
            'priority'=> 'required'
        ]);

        if($validator->fails()){
            return sendError($validator->errors()->first());
        }

       $task = Task::create([
            'user_id' => Auth::user()->id,
            'title'=>$request->title,
            'description'=>$request->description,
            'priority'=>$request->priority,
        ]);
        
            // return sendResponse($task);
            return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        if(Auth::user()->id !== $task->user_id){
            return sendError('You are not authorized to make this request');
        }
            return new TasksResource($task);

            // use ternary operator 
            // return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) : new TasksResource($task);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if(Auth::user()->id !== $task->user_id){
            return sendError('You are not authorized to make this request');
        }
        $task->update($request->all());
        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) : $task->delete();
    }
    



    // unauthorized user define once and used it anywhere
    public function isNotAuthorized($task){
        if(Auth::user()->id !== $task->user_id){
            return sendError('You are not authorized to make this request');
        }
    }
}
