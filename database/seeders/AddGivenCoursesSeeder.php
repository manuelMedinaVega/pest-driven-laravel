<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddGivenCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->isDataAlreadyGiven()) {
            return;
        }
        Course::create([
            'paddle_product_id' => 'pri_01jf9c4rcg9ttv9aj4dz4n6jtw',
            'slug' => Str::of('Laravel for beginners')->slug(),
            'title' => 'Laravel for beginners',
            'tagline' => 'Make your first steps as a Laravel dev.',
            'description' => 'A video course to teach you Laravel from scratch.',
            'image_name' => 'laravel_for_beginners.png',
            'learnings' => [
                'How to start with Laravel',
                'Where to start with Laravel',
                'Build your first Laravel application',
            ],
            'released_at' => now(),
        ]);

        Course::create([
            'paddle_product_id' => 'pri_01jf9c4rcg9ttv9aj4dz4n6jtw',
            'slug' => Str::of('Advanced Laravel')->slug(),
            'title' => 'Advanced Laravel',
            'tagline' => 'Level up as a Laravel developer.',
            'description' => 'A video course to teach you advanced techniques in Laravel.',
            'image_name' => 'advanced_laravel.png',
            'learnings' => [
                'How to use the service container',
                'Pipelines in Laravel',
                'Secure your application',
            ],
            'released_at' => now(),
        ]);

        Course::create([
            'paddle_product_id' => 'pri_01jf9c4rcg9ttv9aj4dz4n6jtw',
            'slug' => Str::of('TDD the Laravel way')->slug(),
            'title' => 'TDD the Laravel way',
            'tagline' => 'Give testing the importance it deserves.',
            'description' => 'A video course to teach you test-driven development in a Laravel application.',
            'image_name' => 'tdd_the_laravel_way.png',
            'learnings' => [
                'What TDD is',
                'How to use TDD in Laravel',
                'Work on a TDD mindset',
            ],
            'released_at' => now(),
        ]);
    }

    private function isDataAlreadyGiven(): bool
    {
        return Course::where('title', 'Laravel for beginners')->exists()
            && Course::where('title', 'Advanced Laravel')->exists()
            && Course::where('title', 'TDD the Laravel way')->exists();
    }
}
