<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function getUrlAttribute(){
       // return route('question.show',$this->id);
        return '#';
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute(){
        $email = $this->email;
//        $default = "https://www.somewhere.com/homestar.jpg";
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d". "&s=" . $size;
    }

    public function favorites(){
        return $this->belongsToMany(Question::class,'favorites')->withTimestamps();//'user_id','question_id');
    }

    public function voteQuestions(){
        return $this->morphedByMany(Question::class,'votable');//votables get votable
    }
    public function voteAnswers(){
        return $this->morphedByMany(Answer::class,'votable');
    }

    public function voteQuestion(Question $question,$vote){
        $voteQuestion=$this->voteQuestions();
        if($voteQuestion->where('votable_id',$question->id)->exists()){
            $voteQuestion->updateExistingPivot($question,['vote'=>$vote]);
        }
        else{
            $voteQuestion->attach($question,['vote'=>$vote]);
        }

        $question->load('votes');
      $downVotes=  (int)$question->downVotes()->sum('vote');
      $upVotes=  (int)$question->upVotes()->sum('vote');
        $question->votes_count = $upVotes + $downVotes;
        $question->save();
    }


}
