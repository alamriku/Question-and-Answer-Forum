<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Auth;
class Question extends Model
{
    protected  $fillable = ['title','body'];

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
                if($this->best_answer_id){
                    return 'answered-accepted';
                }
                return 'answered';
            }
            return 'unanswered';
    }

    public function answers(){
        return $this->hasMany(Answer::class);
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

    public function votes(){
        return $this->morphToMany(User::class,'votable');
    }

    public function upVotes(){
        return $this->votes()->where('vote',1);
    }

    public function downVotes(){
        return $this->votes()->where('vote',-1);
    }
}
