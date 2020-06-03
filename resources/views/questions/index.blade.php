@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('layouts._messages')
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                           <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        @foreach($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="vote">
                                        <strong>{{$question->votes}}</strong> {{\Illuminate\Support\Str::plural('vote',$question->votes)}}
                                    </div>
                                    <div class="status {{$question->status}}">
                                        <strong>{{$question->answers}}</strong> {{\Illuminate\Support\Str::plural('answers',$question->votes)}}
                                    </div>
                                    <div class="view">
                                        {{$question->views ." ".\Illuminate\Support\Str::plural('view',$question->view)}}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{$question->url}}">{{$question->title}}</a></h3>
                                        <div class="ml-auto">
                                            @if(Auth::user()->can('update-question',$question))
                                            <a href="{{route('questions.edit',$question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>

                                                @endif
                                                @if(Auth::user()->can('delete-question',$question))

                                                    <form class="form-delete" action="{{route('questions.destroy',$question->id)}} " method="post">
                                                        {{method_field('DELETE')}}
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Are your Sure?')">Delete</button>
                                                    </form>
                                                @endif
                                        </div>
                                    </div>

                                      <p class="lead">
                                          Asked By <a href="{{$question->user->url }}">{{$question->user->name}}</a>
                                          <small class="text-muted">{{$question->created_date}}</small>
                                      </p>
                                        {{ \Illuminate\Support\Str::limit($question->body,250) }}
                                </div>
                            </div>
                            <hr>
                            @endforeach
                        {{
                            $questions->links()
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
