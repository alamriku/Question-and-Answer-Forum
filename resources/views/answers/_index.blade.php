<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{$answersCount." ".Str::plural('Answer',$question->answers_count)}}</h2>
                </div>
                <hr>
                @include('layouts._messages')
                @foreach($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a href="" title="This Answer is useful"
                               class="vote-up {{Auth::guest() ? 'off':''}}"
                               onclick="event.preventDefault();document.getElementById('up-vote-answer-{{$answer->id}}').submit()"
                            >
                                <form action="/answers/{{$answer->id}}/vote" id="up-vote-answer-{{$answer->id}}" method="post" style="display: none">

                                    <input type="hidden" name="vote" value="1">
                                    @csrf

                                </form>
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">{{$answer->votes_count}}</span>
                            <a href="" title="This question is not useful"
                               class="vote-down {{Auth::guest() ? 'off':''}}"
                               onclick="event.preventDefault();document.getElementById('down-vote-answer-{{$answer->id}}').submit()"
                            >
                                <form action="/answers/{{$answer->id}}/vote" id="down-vote-answer-{{$answer->id}}" method="post" style="display: none">

                                    <input type="hidden" name="vote" value="-1">
                                    @csrf

                                </form>
                                <i class="fas fa-caret-down fa-3x"></i>

                            </a>
                            @can('accept',$answer)
                            <a href="" title="Mark this answer as best answer"
                               class="{{$answer->status}} mt-2 "
                               onclick="event.preventDefault();document.getElementById('accept-answer-{{$answer->id}}').submit()"
                            >
                                <i class="fas fa-check fa-2x"></i>
                            </a>

                            <form action="{{route('answers.accept',$answer->id)}}" id="accept-answer-{{$answer->id}}" method="post" style="display: none">
                                @csrf
                            </form>
                                @else
                                @if($answer->is_best)
                                    <a href="" title="The user Marked this answer as best answer"
                                       class="{{$answer->status}} mt-2 "
                                    >
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                    @endif
                                @endcan
                        </div>
                        <div class="media-body">
                            {!! parsedown($answer->body) !!}
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        @can('update',$answer)
                                            <a href="{{route('questions.answers.edit',[$question->id,$answer->id])}}" class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan
                                        @can('delete',$answer)
                                            <form class="form-delete" action="{{route('questions.answers.destroy',[$question->id,$answer->id])}} " method="post">
                                                {{method_field('DELETE')}}
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Are your Sure?')">Delete</button>
                                                @endcan
                                            </form>
                                    </div>

                                </div>
                                <div class="col-4"></div>
                                <div class="col-4 ">
                                        <span class="text-muted">
                                            Answered {{$answer->created_date}}
                                        </span>
                                    <div class="media mt-2">
                                        <a href="{{$answer->user->url}}" class="pr-2 ">
                                            <img src="{{$answer->user->avatar}}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{$answer->user->url}}" >{{$answer->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
