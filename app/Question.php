<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Auth;
class Question extends Model
{
    use VotableTrait;

    protected  $fillable = ['title','body'];
    protected $appends=['created_date','is_favorited','favorites_count'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    //this is eloquent mutator
    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }


    //this is eloquent accessor
    public function getUrlAttribute(){
        return route('questions.show',$this->slug);
    }

    public function getCreatedDateAttribute(){
        //diffForHumans is a carbon date method
        return $this->created_at->diffForHumans();
       // return $this->created_at->formate('d/m/Y');
    }

    public function getStatusAttribute(){
            if($this->answers_count > 0){
                if($this->best_ans_id){
                    return 'answered-accepted';
                }
                return 'answered';
            }
            return 'unanswered';
    }

    public function answers(){
        return $this->hasMany(Answer::class)->orderBy('votes_count','DESC');
    }

    public function acceptBestAnswer(Answer $answer){
        $this->best_ans_id = $answer->id;
        $this->save();
    }

    public function favorites(){
        return $this->belongsToMany(User::class,'favorites')->withTimestamps();//'question_id','use_id');
    }

    public function isFavorited(){

        if(Auth::check()){
            return $this->favorites()->where('user_id',Auth::user()->id)->count() >0;
        }

    }
    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }
    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }
    public function getBodyHtmlAttribute()
    {
        return (clean($this->bodyHtml()));
    }
    private function bodyHtml(){
        return \Parsedown::instance()->text($this->body);
    }

    public function getExcerptAttribute(){
        return $this->excerpt(2);

    }

    public function excerpt($length){
        return  \Illuminate\Support\Str::limit(strip_tags($this->bodyHtml()),$length);
    }
//    public function setBodyAttribute($value){
//        $this->attributes['body']=clean($value);
//    }
}
