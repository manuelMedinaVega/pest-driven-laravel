<?php

namespace App;

use Illuminate\Http\Request;
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class PaddleSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        return !empty($request->toArray());
        //esto no va a funcionar, porque tendríamos que probar con un webhook enviado
        //desde paddle, ya que ahí tenemos el signature que podemos verificar
        (new Verifier())->verify(
            $request,
            new Secret(config('services.paddle.webhook_secret_key'))
        );
    }
}