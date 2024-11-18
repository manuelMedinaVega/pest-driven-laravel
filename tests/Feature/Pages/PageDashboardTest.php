<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\get;

it('cannot be accesed by guest', function () {
    // Act & Assert
    get(route('pages.dashboard'))
        ->assertRedirect(route('login'));

});

it('lists purchased courses', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory()->count(2)->state(
            new Sequence(
                ['title' => 'Course A'],
                ['title' => 'Course B']
            )
        ))
        ->create();

    // Act & Assert
    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText([
            'Course A',
            'Course B',
        ]);
});

it('does not list other courses', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSeeText($course->title);
});

it('shows latest purchased course first', function () {
    // Arrange
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->courses()->attach($firstPurchasedCourse, ['created_at' => now()->yesterday()]);
    $user->courses()->attach($lastPurchasedCourse, ['created_at' => now()]);

    // Act & Assert
    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            $lastPurchasedCourse->title,
            $firstPurchasedCourse->title,
        ]);
});

it('includes link to product videos', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory())
        ->create();

    // Act & Assert
    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch videos')
        ->assertSee(route('pages.course-videos', Course::first()));
});

it('includes logout if logged in', function () {
    // Act & Assert
    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});
