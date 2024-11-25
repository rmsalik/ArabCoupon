<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::insert([
            ['name'  => "Question One", 'created_at' => now(), 'updated_at' => now()],
            ['name'  => "Question Two", 'created_at' => now(), 'updated_at' => now()],
            ['name'  => "Question Three", 'created_at' => now(), 'updated_at' => now()],
            ['name'  => "Question Four", 'created_at' => now(), 'updated_at' => now()],
            ['name'  => "Question Five", 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
