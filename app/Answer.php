<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public  function getBodyAttribute()
    {
        return new HtmlString(
            app(Parsedown::class)->setSafeMode(true)->text($this->body)
        );
    }

    public static function boot(){
        parent::boot();

        static::created(function($answer){
           // echo "Answer Created\n";
            $answer->question()->increment('answers_count');
        });

//        static::saved(function ($answer){
//            echo "Answer Saved";
//        });
    }
}
