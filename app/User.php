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


    protected  $appends=['url','avatar'];
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
        return $this->morphedByMany(Question::class,'votable')->withTimestamps();//votable get converted by laravel behide the seen votables
    }
    public function voteAnswers(){
        return $this->morphedByMany(Answer::class,'votable')->withTimestamps();
    }

    public function voteQuestion(Question $question,$vote){
        $voteQuestion=$this->voteQuestions();
        $this->_vote($voteQuestion,$question,$vote);
    }

    public function voteAnswer(Answer $answer,$vote){
        $voteAnswer=$this->voteAnswers();
        $this->_vote($voteAnswer,$answer,$vote);

    }

    private function _vote($relationship,$model,$vote){
        if($relationship->where('votable_id',$model->id)->exists()){
            $relationship->updateExistingPivot($model,['vote'=>$vote]);
        }
        else{
            $relationship->attach($model,['vote'=>$vote]);
        }

        $model->load('votes');
        $downVotes=  (int)$model->downVotes()->sum('vote');
        $upVotes=  (int)$model->upVotes()->sum('vote');
        $model->votes_count = $upVotes + $downVotes;
        $model->save();
    }


}
