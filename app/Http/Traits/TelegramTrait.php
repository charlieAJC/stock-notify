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

    /**
     * 判斷接收資訊內容並回傳訊息
     *
     * @param array $message
     * @return array
     */
    public function processMessage(array $message): array
    {
        $messageId = $message['message_id'];
        $chatId = $message['chat']['id'];

        ## 假如接收資訊裡沒有文字訊息
        if (!isset($message['text'])) {
            return $this->apiRequest('sendMessage', [
                'chat_id' => $chatId,
                'text' => 'I understand only text messages',
            ]);
        }

        $text = $message['text'];
        if (stripos($text, '/start') === 0) {
            $replyMarkup = [
                'inline_keyboard' => [
                    [['text' => 'Hello', 'callback_data' => 'Hello'], ['text' => 'Hi', 'callback_data' => 'Hi']],
                    [['text' => '123', 'callback_data' => '123'], ['text' => '666', 'callback_data' => '666']],
                ],
            ];
            $replyMarkup = json_encode($replyMarkup);
            return $this->apiRequest('sendMessage', [
                'chat_id' => $chatId,
                'text' => 'Welcome! I can help you... err..., where am I?',
                // 'reply_markup' => [['Hello', 'Hi']],
                'reply_markup' => $replyMarkup,
                // 'one_time_keyboard' => true,
                // 'resize_keyboard' => true,
            ]);
        } elseif (in_array($text, ['Hello', 'Hi'])) {
            return $this->apiRequest('sendMessage', [
                'chat_id' => $chatId,
                'text' => 'Nice to meet you :D',
            ]);
            // } elseif (stripos($text, '/stop') === 0) {
            //     // stop now
        }
        return $this->apiRequest('sendMessage', [
            'chat_id' => $chatId,
            'reply_to_message_id' => $messageId,
            'text' => 'Cool!',
        ]);
    }
}
