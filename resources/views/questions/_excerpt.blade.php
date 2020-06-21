<div class="media post" style="{{$loop->iteration == $loop->last ? 'border-bottom:0px !important': ''}}">
    <div class="d-flex flex-column counters">
        <div class="vote ">
            <strong>{{$question->votes_count}}</strong> {{\Illuminate\Support\Str::plural('Vote',$question->votes_count)}}
        </div>
        <div class="status {{$question->status}}">
            <strong>{{$question->answers_count}}</strong> {{\Illuminate\Support\Str::plural('answer',$question->answers_count)}}
        </div>
        <div class="view">
            {{$question->views ." ".\Illuminate\Support\Str::plural('view',$question->views)}}
        </div>
    </div>
    <div class="media-body">
        <div class="d-flex align-items-center">
            <h3 class="mt-0"><a href="{{$question->url}}">{{$question->title}}</a></h3>
            <div class="ml-auto">
                @can('update',$question)
                    <a href="{{route('questions.edit',$question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>
                @endcan
                @can('delete',$question)
                    <form class="form-delete" action="{{route('questions.destroy',$question->id)}} " method="post">
                        {{method_field('DELETE')}}
                        @csrf
                        <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Are your Sure?')">Delete</button>
                        @endcan
                    </form>
            </div>
        </div>

        <p class="lead">
            Asked By <a href="{{$question->user->url }}">{{$question->user->name}}</a>
            <small class="text-muted">{{$question->created_date}}</small>
        </p>
        <div class="excerpt">
            {{ $question->excerpt(350) }}
        </div>

    </div>
</div>
