@if($model instanceof App\Question)
    @php
        $name='question';
        $firstURISegment='questions';
        @endphp
    @elseif($model instanceof App\Answer)
    @php
        $name='answer';
        $firstURISegment='answers';
    @endphp
    @endif
@php
$formId=$name."-".$model->id;
$formAction="/{$firstURISegment}/{$model->id}/vote"

@endphp
<div class="d-flex flex-column vote-controls">
    <a href="" title="This {{$name}} is useful"
       class="vote-up {{Auth::guest() ? 'off':''}}"
       onclick="event.preventDefault();document.getElementById('up-vote-{{$formId}}').submit()"
    >
        <form action="{{$formAction}}" id="up-vote-{{$formId}}" method="post" style="display: none">

            <input type="hidden" name="vote" value="1">
            @csrf

        </form>
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <span class="votes-count">{{$model->votes_count}}</span>
    <a href="" title="This {{$name}} is not useful"
       class="vote-down {{Auth::guest() ? 'off':''}}"
       onclick="event.preventDefault();document.getElementById('down-vote-{{$formId}}').submit()"
    >
        <form action="{{$formAction}}" id="down-vote-{{$formId}}" method="post" style="display: none">

            <input type="hidden" name="vote" value="-1">
            @csrf

        </form>
        <i class="fas fa-caret-down fa-3x"></i>

    </a>

    @if($model instanceof App\Question)
{{--            @include('shared._favorite',[--}}
{{--            'mode'=>$model--}}
{{--            ])--}}
        <favorite :question="{{$model}}"></favorite>
         @elseif($model instanceof App\Answer)
{{--        @include('shared._accept',[--}}
{{--           'mode'=>$model--}}
{{--           ])--}}
        <accept :answer="{{$model}}"></accept>
        @endif

</div>
