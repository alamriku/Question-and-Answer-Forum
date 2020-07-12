@extends('layouts.app')

@section('content')
    <div class="container">
        <question-page :question="{{$question}}"></question-page>
{{--        @include('answers._index',['answers'=>$question->answers,--}}
{{--        'answersCount'=>$question->answers_count--}}
{{--        ])--}}

{{--        @include('answers._create')--}}
    </div>
@endsection
