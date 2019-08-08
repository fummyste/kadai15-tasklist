<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $tasks = Task::where("user_id",\Auth::id())->orderBy('id', 'desc')->paginate(25);

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);



        $task= new Task;
        $task->content=$request->content;
        $task->status = $request->status;
        $task->user_id =\Auth::id();
        $task->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $task = Task::find($id);
        if(\Auth::id() === $task->user_id){
            return view('tasks.show', [
                'task' => $task,
            ]);
        }else{
            return redirect('/');
        }            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $task = Task::find($id);

         if(\Auth::id() === $task->user_id){
        return view('tasks.edit', [
            'task' => $task,
        ]);
         }{
             return back();
         }
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
        
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        
        $task = Task::find($id);
             if(\Auth::id() === $task->user_id){
            $task->content = $request->content;
            $task->status = $request->status;
            $task->user_id = \Auth::id();
            $task->save();
        return redirect('/');
         }else{
             return back();
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
            $task = Task::find($id);
        if(\Auth::id() === $task->user_id){
            $task->delete();
            return redirect('/');
        }else{
            return back();
        }
    }
}
