<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index']]);
    }
    public function index(Question $question){
        return $question->answers()->with('user')->simplePaginate(3);
    }
    public function store(Question $question,Request $request)
    {
//        $request->validate([
//            'body'=>'required'
//        ]);
//        $question->answers()->create(['body'=>$request->body,'user_id'=>\Auth::id()]);

        $question->answers()->create( $request->validate([
            'body'=>'required'
        ]) + ['user_id'=>\Auth::id()]);

        return back()->with('success','Your answer has been submitted successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question,Answer $answer)
    {
        $this->authorize('update',$answer);

        return view('answers.edit',compact('question','answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Question $question, Answer $answer)
    {
        $this->authorize('update',$answer);

        $answer->update($request->validate(
            ['body'=>'required']
        ));
        if($request->expectsJson()){
            return response()->json([
                'message'=>'your answer is updated',
                'body_html'=>$answer->body_html
            ]);
        }

        return redirect()->route('questions.show',$question->slug)->with('success','your answer is updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,Answer $answer)
    {
        $this->authorize('delete',$answer);
        $answer->delete();
        if(\request()->expectsJson()){
            return  response()->json([
                'message'=>'Your answer has been removed'
            ]);
        }
        return back()->with('success','Your answer has been removed');
    }
}
