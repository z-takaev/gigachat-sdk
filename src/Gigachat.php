<?php

namespace Ztakaev\Gigachat;

use Illuminate\Support\Facades\Http;

class Gigachat
{
    public function getToken()
    {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Basic Njc5MmU2MDgtODdlNC00ODliLTgwZDEtNzcwMGJjNTNhZjZlOjg1NjdiY2NmLTBmMzgtNGIzMC04Y2VkLWYzOTI4M2FiNTBjZA==',
                'RqUID' => (string)str()->uuid(),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])
            ->withBody('scope=GIGACHAT_API_PERS', 'application/x-www-form-urlencoded')
            ->post('https://ngw.devices.sberbank.ru:9443/api/v2/oauth');

        $token = $response->json('access_token');

        return $token;
    }

    public function textRequest(string $text)
    {
        $request = Http::withoutVerifying()
            ->withHeader('Content-Type', 'application/json')
            ->withToken($this->getToken())
            ->post(
                'https://gigachat.devices.sberbank.ru/api/v1/chat/completions',
                [
                    'model' => 'GigaChat:latest',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $text,
                        ]
                    ],
                    'temperature' => 2,
                ]
            );

        return $request->json('choices.0.message.content');
    }
}
