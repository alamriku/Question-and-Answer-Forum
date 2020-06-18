@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @include('layouts._messages')
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h2>{{$question->title}}</h2>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to question</a>
                                </div>
                            </div>

                        </div>
                        <hr>

                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a href="" title="This question is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">1230</span>
                                <a href="" title="This question is not useful" class="vote-down off">
                                    <i class="fas fa-caret-down fa-3x"></i>

                                </a>
                                <a href="" title="Click to mark as favourite question(click again to undo)" class=" mt-2 {{ Auth::check() ? 'off' :($question->is_favorited) ? 'favorite': ''}}"
                                   onclick="event.preventDefault();document.getElementById('favorite-question-{{$question->id}}').submit()"
                                >
                                    <i class="fas fa-star fa-2x"></i>

                                    <form action="/questions/{{$question->id}}/favorites" id="favorite-question-{{$question->id}}" method="post" style="display: none">

                                        @if($question->is_favorited)
                                            @method('DELETE')
                                        @endif
                                        @csrf

                                    </form>
                                    <span class="favorites-count">{{$question->favorites_count}}</span>
                                </a>


                            </div>
                            <div class="media-body">
                                {!! parsedown($question->body)  !!}
                                <div class="float-right">
                                        <span class="text-muted">
                                            Answered {{$question->created_date}}
                                        </span>
                                    <div class="media mt-2">
                                        <a href="{{$question->user->url}}" class="pr-2">
                                            <img src="{{$question->user->avatar}}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{$question->user->url}}" >{{$question->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        @include('answers._index',['answers'=>$question->answers,
        'answersCount'=>$question->answers_count
        ])

        @include('answers._create')
    </div>
@endsection
