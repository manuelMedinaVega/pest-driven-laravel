<?php

use App\Jobs\HandlePaddlePurchaseJob;
use Illuminate\Support\Facades\Queue;
use Spatie\WebhookClient\Models\WebhookCall;

it('stores a paddle purchase request', function () {
    // Arrange
    Queue::fake();
    $this->assertDatabaseCount(WebhookCall::class, 0);

    // Act
    $this->post('webhooks', getValidPaddleRequestData());

    // Assert
    $this->assertDatabaseCount(WebhookCall::class, 1);
});

it('does not store invalid paddle purchase request', function () {
    // Arrange
    $this->assertDatabaseCount(WebhookCall::class, 0);

    // Act
    $this->post('webhooks', getInvalidPaddleRequestData());

    // Assert
    $this->assertDatabaseCount(WebhookCall::class, 0);
});

it('dispatches a job for valid paddle request', function () {
    // Arrange
    Queue::fake();

    // Act
    $this->post('webhooks', getValidPaddleRequestData());

    // Assert
    Queue::assertPushed(HandlePaddlePurchaseJob::class);
});

it('does not dispatch a job for invalid paddle request', function () {
    // Arrange
    Queue::fake();

    // Act
    $this->post('webhooks', getInvalidPaddleRequestData());

    // Assert
    Queue::assertNothingPushed();
});

function getValidPaddleRequestData(): array
{
    return [
        'event_id' => 'ntfsimevt_01jfgarecakh22s59y8p4fd52h',
        'event_type' => 'payout.paid',
        'occurred_at' => '2024-12-19T20:46:43.594928Z',
        'notification_id' => 'ntfsimntf_01jfgareh1hr0h0ctcv8bwans0',
        'data' => [
            'id' => 'pay_01gsz4vmqbjk3x4vvtafffd540',
            'amount' => '10000',
            'status' => 'paid',
            'currency_code' => 'USD',
        ],
    ];
}

function getInvalidPaddleRequestData(): array
{
    return [];
}
