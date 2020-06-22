<a href="" title="Click to mark as favourite question(click again to undo)" class=" mt-2 {{ Auth::check() ? 'off' :($model->is_favorited) ? 'favorite': ''}}"
   onclick="event.preventDefault();document.getElementById('favorite-question-{{$model->id}}').submit()"
>
    <i class="fas fa-star fa-2x"></i>

  
    <span class="favorites-count">{{$model->favorites_count}}</span>
</a>
<form action="/questions/{{$model->id}}/favorites" id="favorite-question-{{$model->id}}" method="post" style="display: none">
    
    @if($model->is_favorited)
        @method('DELETE')
    @endif
    @csrf

</form>
