@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('layouts._messages')
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>{{$question->title}}</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to question</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
{{--                        {{$question->body}}--}}
                        {!! parsedown($question->body)  !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
