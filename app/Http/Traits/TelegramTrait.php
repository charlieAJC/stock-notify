<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

trait TelegramTrait
{
    /**
     * 用 GET 發送訊息給指定用戶
     *
     * @param string $method sendMessage:傳送訊息
     * @param array  $parameters
     * @return array
     */
    public function apiRequest(string $method, array $parameters): array
    {
        $response = Http::get(config('notify.telegram.api_url') . $method, $parameters);
        return $response->json();
    }

    /**
     * 用 POST 發送訊息給指定用戶
     *
     * @param string $method sendMessage:傳送訊息
     * @param array $parameters
     * @return array
     */
    public function apiRequestJson(string $method, array $parameters): array
    {
        ## GET 和 POST 發送訊息的差別只在 $method 放在 url parameter 或是 request body
        $parameters['method'] = $method;
        $response = Http::post(config('notify.telegram.api_url'), $parameters);
        return $response->json();
    }
}
