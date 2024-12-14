<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AddLocalTestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(App::environment() == 'local') {
            User::truncate();
            $user = User::create([
                'email' => 'test@test.com',
                'name' => 'Manu',
                'password' => bcrypt('123456')
            ]);

            $courses = Course::all();
            $user->purchasedCourses()->attach($courses);
        }
    }
}
