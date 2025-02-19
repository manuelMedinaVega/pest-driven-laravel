<?php

use App\Models\Course;

use function Pest\Laravel\get;

it('shows courses overview', function () {
    // Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.home'))->assertSeeText([
        $firstCourse->title,
        $firstCourse->description,
        $secondCourse->title,
        $secondCourse->description,
        $thirdCourse->title,
        $thirdCourse->description,
    ]);

});

it('shows only released courses', function () {
    // Arrange
    $releasedCourse = Course::factory()->released()->create();
    $notReleasedCourse = Course::factory()->create();

    // Act & Assert
    get(route('pages.home'))->assertSeeText($releasedCourse->title)
        ->assertDontSeeText($notReleasedCourse->title);
});

it('shows courses by release date', function () {
    // Arrange
    $releasedCourse = Course::factory()->released(now()->yesterday())->create();
    $newestReleasedCourse = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.home'))->assertSeeTextInOrder([
        $newestReleasedCourse->title,
        $releasedCourse->title,
    ]);
});

it('includes login if not logged in', function () {
// Act & Assert
get(route('pages.home'))
->assertOk()
->assertSeeText('Login')
->assertSee(route('login'));
    });

it('includes logout if logged in', function () {
    // Act & Assert
    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});

it('includes courses links', function () {
    // Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $lastCourse = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSee([
            route('pages.course-details', $firstCourse),
            route('pages.course-details', $secondCourse),
            route('pages.course-details', $lastCourse),
        ]);
});

it('includes title', function () {
    // Arrange
    $expectedTitle = config('app.name').' - Home';
    
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSee("<title>$expectedTitle</title>", false);
});

it('includes social tags', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSee([
            '<meta name="description" content="LaravelCasts is the leading learning platform for Laravel developers.">',
            '<meta property="og:type" content="website">',
            '<meta property="og:url" content="' . route('pages.home'). '">',
            '<meta property="og:title" content="LaravelCasts">',
            '<meta property="og:description" content="LaravelCasts is the leading learning platform for Laravel developers.">',
            '<meta property="og:image" content="'. asset('images/social.png') .'">',
            '<meta name="twitter:card" content="summary_large_image">'
        ], false);
});