<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // \DB::enableQueryLog();
        // user is the method name in question model with('user') represent the eager loading
        $questions = Question::with('user')->latest()->paginate(5);
         //view('questions.index',compact('questions'))->render();
        return view('questions.index',compact('questions'));
        //dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();

        return view('questions.create',compact($question));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
      $request->user()->questions()->create($request->only('title','body'));
      return redirect()->route('questions.index')->with('success',"Your Question has been submitted");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function show(Question $questions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('questions.edit',compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title','body'));
        return redirect('/questions')->with('success','Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect('/questions')->with('success','Your question has been deleted');
    }
}
