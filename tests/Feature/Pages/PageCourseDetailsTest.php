<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Support\Facades\App;

use function Pest\Laravel\get;

it('does not find unreleased course', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertNotFound();
});

it('shows course details', function () {
    // Arrange
    $course = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            $course->tagline,
            ...$course->learnings,
        ])
        ->assertSee(asset("images/$course->image_name"));
});

it('shows course video count', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()->count(3))
        ->released()
        ->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');
});

it('includes paddle checkout button', function () {
    // Arrange
    //App::partialMock()->shouldReceive('environment')->andReturn('local');
    config()->set('services.paddle.client_token', 'client_token');
    $course = Course::factory()
        ->released()
        ->create([
            'paddle_product_id' => 'product-id',
        ]);

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSee('<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>', false)
        ->assertSee('Paddle.Environment.set("sandbox");', false)
        ->assertSee('Paddle.Initialize({token: "client_token"});', false)
        ->assertSee('let itemsList = [{priceId: "product-id"}]', false)
        ->assertSee('<a href="#" onclick="openCheckout(itemsList)">Buy now</a>', false)
        ->assertSee('function openCheckout(items){', false);

});
