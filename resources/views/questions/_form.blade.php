<div class="form-group">
    <label for="question-title">Question Title</label>
    <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" name="title" value="{{old('title',$question ? $question->title: '')}}" id="question-title">
    @if($errors->has('title'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('title') }}</strong>
        </div>
    @endif
</div>
<div class="form-group">
    <label for="question-body">Explain Question </label>
    <textarea type="text" class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}" name="body" rows="10" id="question-body">{{old('body',$question ? $question->body:'')}}</textarea>
    @if($errors->has('body'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('body') }}</strong>
        </div>
    @endif
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary btn-lg">{{$buttonText}}</button>
</div>
