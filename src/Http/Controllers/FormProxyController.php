<?php

namespace Formflex\Proxy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FormProxyController
{
    private function client()
    {
        $baseUrl = config('formflex.base_url');

        return Http::baseUrl($baseUrl)
            ->withToken($this->getToken())
            ->timeout(10);
    }

    public function authenticate(string $email): array
    {
        return $this->hmacPost('/api/v1/service/auth', [
            'user' => $email,
        ]);
    }

    protected function getToken(): string
    {
        $auth = $this->authenticate(config('formflex.auth.user_email'));
        return $auth['token'];
    }

    protected function hmacPost(string $endpoint, array $body = []): ?array
    {

        $baseUrl = rtrim(config('formflex.base_url'), '/');
        $secret = config('formflex.auth.service_hmac_secret');

        $timestamp = (string)now()->timestamp;
        $rawBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $signature = hash_hmac('sha256', $timestamp . '.' . $rawBody, $secret);

        $response = Http::acceptJson()
            ->contentType('application/json')
            ->withHeaders([
                'X-Service-Timestamp' => $timestamp,
                'X-Service-Signature' => $signature,
            ])
            ->post($baseUrl . $endpoint, $body);

        if ($response->failed()) {
            Log::debug($response->json());
            return null;
        }

        return $response->json();
    }

    public function show(string $id)
    {
        $response = $this->client()
            ->get("/api/v1/client/form-versions/{$id}");

        return response()->json($response->json(), $response->status());
    }

    public function fetchLookupList(string $id)
    {
        $response = $this->client()
            ->get("/api/v1/client/data-lists/{$id}");

        return response()->json($response->json(), $response->status());
    }
}
