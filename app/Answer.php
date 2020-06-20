<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use VotableTrait;

    protected $fillable = ['body','user_id'];
    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getCreatedDateAttribute(){
        //diffForHumans is a carbon date method
        return $this->created_at->diffForHumans();
        // return $this->created_at->formate('d/m/Y');
    }

    public function getStatusAttribute(){
        return $this->isBest() ? 'vote-accepted': '';
    }

    public function getIsBestAttribute(){
        return $this->isBest();
    }

    public function isBest(){
      return  $this->id == $this->question->best_ans_id;
    }
    //this below boot is active when a model life cycle is started
    public static function boot(){
        parent::boot();

        static::created(function($answer){
           // echo "Answer Created\n";
            $answer->question()->increment('answers_count');
        });

        static::deleted(function ($answer){

            $answer->question()->decrement('answers_count');

        });
//        static::saved(function ($answer){
//            echo "Answer Saved";
//        });
    }


}
