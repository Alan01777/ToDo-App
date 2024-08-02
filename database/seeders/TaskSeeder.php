<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all()->load('tags', 'categories');

        foreach($users as $user){
            $tagIds = $user->tags->pluck('id')->toArray(); 
            $categoriesId = $user->categories->pluck('id')->toArray();

            Task::factory()->count(random_int(1,3))->create([
                'user_id' => $user->id,
                'tag_id' => Arr::random($tagIds),
                'category_id' => Arr::random($categoriesId)
            ]);
        }
    }
}
