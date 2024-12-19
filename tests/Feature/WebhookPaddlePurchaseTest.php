<?php

use Spatie\WebhookClient\Models\WebhookCall;

it('stores a paddle purchase request', function () {
    // Arrange
    $this->assertDatabaseCount(WebhookCall::class, 0);

    // Act
    $this->post('webhooks', [
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
    ]);

    //Assert
    $this->assertDatabaseCount(WebhookCall::class, 1);
});

it('does not store invalid paddle purchase request', function () {
    // Arrange
    $this->assertDatabaseCount(WebhookCall::class, 0);

    // Act
    $this->post('webhooks', []);

    //Assert
    $this->assertDatabaseCount(WebhookCall::class, 0);
});
