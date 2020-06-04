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
    public static function getBodyAttribute($value)
    {
        return new HtmlString(
            app(Parsedown::class)->setSafeMode(true)->text($text)
        );
    }
}
