<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\App;

it('adds given courses', function () {
    // Assert
    $this->assertDatabaseCount(Course::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Course::class, 3);
    $this->assertDatabaseHas(Course::class, ['title' => 'Laravel for beginners']);
    $this->assertDatabaseHas(Course::class, ['title' => 'Advanced Laravel']);
    $this->assertDatabaseHas(Course::class, ['title' => 'TDD the Laravel way']);
});

it('adds given courses only once', function () {
    // Assert
    $this->assertDatabaseCount(Course::class, 0);

    // Act
    $this->artisan('db:seed');
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Course::class, 3);
});

it('adds given videos', function () {
    // Assert
    $this->assertDatabaseCount(Video::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $laravelForBeginnersCourse = Course::where('title', 'Laravel for beginners')->firstOrFail();
    $advancedLaravelCourse = Course::where('title', 'Advanced Laravel')->firstOrFail();
    $tddTheLaravelWayCourse = Course::where('title', 'TDD the Laravel way')->firstOrFail();
    $this->assertDatabaseCount(Video::class, 8);

    expect($laravelForBeginnersCourse)->videos->toHaveCount(3);
    expect($advancedLaravelCourse)->videos->toHaveCount(3);
    expect($tddTheLaravelWayCourse)->videos->toHaveCount(2);
});

it('adds given videos only once', function () {
    // Assert
    $this->assertDatabaseCount(Video::class, 0);

    // Act
    $this->artisan('db:seed');
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Video::class, 8);
});

it('adds local test user', function () {
    // Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('local');

    // Assert
    $this->assertDatabaseCount(User::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(User::class, 1);
});

it('does not add test user for production', function () {
    // Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('production');

    // Assert
    $this->assertDatabaseCount(User::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(User::class, 0);
});
