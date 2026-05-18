<?php

namespace Formflex\Proxy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FormProxyController
{
    private string $baseUrl = 'https://local.formflex.pw';

    private function client()
    {
        $baseUrl = config('formflex.base_url');
        $authType = config('formflex.auth.type');

        $http = \Illuminate\Support\Facades\Http::baseUrl($baseUrl)->timeout(10);

        if ($authType === 'bearer') {
            $http = $http->withToken(config('formflex.auth.bearer_token'));
        }

        if ($authType === 'api_key') {
            $http = $http->withHeaders([
                config('formflex.auth.api_key_header') => config('formflex.auth.api_key'),
            ]);
        }

        return $http;
    }
    public function show(string $id)
    {
        $response = $this->client()
            ->get("/api/v1/client/forms/{$id}");

        return response()->json($response->json(), $response->status());
    }
}
