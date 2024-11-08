<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function () {
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'description' => 'Description Course A', 'released_at' => now()->yesterday()]);
    Course::factory()->create(['title' => 'Course B', 'description' => 'Description Course B', 'released_at' => now()->yesterday()]);
    Course::factory()->create(['title' => 'Course C', 'description' => 'Description Course C', 'released_at' => now()->yesterday()]);

    // Act & Assert
    get(route('home'))->assertSeeText([
        'Course A', 
        'Description Course A',
        'Course B',
        'Description Course B',
        'Course C',
        'Description Course C'
    ]);

});

it('shows only released courses', function () {
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'released_at' => now()->yesterday()]);
    Course::factory()->create(['title' => 'Course B']);

    // Act & Assert
    get(route('home'))->assertSeeText([
        'Course A'
    ])->assertDontSeeText([
        'Course B'
    ]);
});

it('shows courses by release date', function () {
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'released_at' => now()->yesterday()]);
    Course::factory()->create(['title' => 'Course B', 'released_at' => now()]);

    // Act & Assert
    get(route('home'))->assertSeeTextInOrder([
        'Course B',
        'Course A'
    ]);
});