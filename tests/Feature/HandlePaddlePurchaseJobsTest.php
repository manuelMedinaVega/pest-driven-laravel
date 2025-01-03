<?php

use App\Jobs\HandlePaddlePurchaseJob;
use App\Mail\NewPurchaseMail;
use App\Models\Course;
use App\Models\PurchasedCourse;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\WebhookClient\Models\WebhookCall;

beforeEach(function () {
    $this->dummyWebhookCall = WebhookCall::create([
        'name' => 'default',
        'url' => 'some-url',
        'payload' => [
            'email' => 'test@test.com',
            'name' => 'Test user',
            'p_product_id' => 'pro_01jf9bjgpr5ey0g4q5j1hwgz1m',
        ],
    ]);
});

it('stores paddle purchase', function () {
    // Assert
    Mail::fake();
    $this->assertDatabaseEmpty(User::class);
    $this->assertDatabaseEmpty(PurchasedCourse::class);

    // Arrange
    $course = Course::factory()->create(['paddle_product_id' => 'pro_01jf9bjgpr5ey0g4q5j1hwgz1m']);

    // Act
    (new HandlePaddlePurchaseJob($this->dummyWebhookCall))->handle();

    // Assert
    $this->assertDatabaseHas(User::class, [
        'email' => 'test@test.com',
        'name' => 'Test user',
    ]);

    $user = User::where('email', 'test@test.com')->first();
    $this->assertDatabaseHas(PurchasedCourse::class, [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
});

it('stores paddle purchase for given user', function () {
    // Arrange
    Mail::fake();
    $user = User::factory()->create(['email' => 'test@test.com']);
    $course = Course::factory()->create(['paddle_product_id' => 'pro_01jf9bjgpr5ey0g4q5j1hwgz1m']);

    // Act
    (new HandlePaddlePurchaseJob($this->dummyWebhookCall))->handle();

    // Assert
    $this->assertDatabaseCount(User::class, 1);
    $this->assertDatabaseHas(User::class, [
        'email' => $user->email,
        'name' => $user->name,
    ]);

    $this->assertDatabaseHas(PurchasedCourse::class, [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
});

it('sends out purchase email', function () {
    // Arrange
    Mail::fake();
    Course::factory()->create(['paddle_product_id' => 'pro_01jf9bjgpr5ey0g4q5j1hwgz1m']);

    // Act
    (new HandlePaddlePurchaseJob($this->dummyWebhookCall))->handle();

    // Assert
    Mail::assertSent(NewPurchaseMail::class);
});
