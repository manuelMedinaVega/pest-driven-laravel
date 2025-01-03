<?php

use App\Mail\NewPurchaseMail;
use App\Models\Course;

it('includes purchase details', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act
    $mail = new NewPurchaseMail($course);

    // Assert
    $mail->assertSeeInHtml("Thanks for purchasing $course->title");
    $mail->assertSeeInHtml('Login');
    $mail->assertSeeInHtml(route('login'));

});
