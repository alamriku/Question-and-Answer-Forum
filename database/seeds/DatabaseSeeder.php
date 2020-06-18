<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(
            [
                UsersQuestionsAnswersTableSeeder::class,
                FavoritesTableSeeder::class,
                VotablesTableSeeder::class
            ]
        );



//        factory(App\Question::class, rand(1,10))->create()
//        ->each(function ($q){
//            $q->answers()->saveMany(factory(App\Answer::class,rand(1,5))->make());
//        });

    }
}
