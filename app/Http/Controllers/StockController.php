<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use App\Traits\TelegramTrait;

class StockController extends Controller
{
    use TelegramTrait;

    public function getTest()
    {
        // https://ithelp.ithome.com.tw/articles/10274778
        // 關於 $this->processMessage() 的 reply_markup 參數
        // https://ithelp.ithome.com.tw/articles/10247929

        // 傳送訊息
        // $response = $this->apiRequest('sendMessage', [
        //     'chat_id' => 835826701,
        //     'text' => 'Hello, World! 你好，世界！',
        // ]);
        // $response = $this->apiRequestJson('sendMessage', [
        //     'chat_id' => 835826701,
        //     'text' => 'Hello, World! 你好，世界！',
        // ]);

        // 接收訊息 1
        // 若不帶任何參數，預設為 24 小時內接收到的所有訊息
        // $response = $this->apiRequest('getUpdates', []);
        // $response = $this->apiRequestJson('getUpdates', []);

        // 接收訊息 2 - Long Polling
        // 每則訊息都會帶 update_id
        // case 1.若 offset 帶已經存在訊息的 update_id，會取到從該訊息發送時間到現在時間內接收到的所有訊息
        //      注意：TG 伺服器會把小於 offset 的 update_id 都當作是你已經處理過的了，並且將這些訊息捨棄，所以你就沒辦法再次讀取了
        // case 2.若帶尚未生成訊息的 update_id，則此連線會維持 timeout 秒，
        //      若在這時間內訊息都沒有生成， timeout 秒後會收到空陣列
        //      若在這時間內訊息生成，會立刻收到該訊息的資訊
        // $response = $this->apiRequest('getUpdates', [
        //     'offset' => 850477351,
        //     'timeout' => 30,
        // ]);

        // 不斷接收訊息後回傳
        // $updateId = 0;
        // while (true) {
        //     $responses = $this->apiRequest('getUpdates', [
        //         'offset' => $updateId,
        //         'timeout' => 30,
        //     ]);
        //     dump($responses);
        //     collect($responses['result'])->map(function ($response) {
        //         // dump($this->processMessage($response['message']));
        //         $this->processMessage($response['message']);
        //     });
        //     if ($responses['result']) {
        //         $lastArrayKey = array_key_last($responses['result']);
        //         $updateId = $responses['result'][$lastArrayKey]['update_id'] + 1;
        //         dump("new update_id is: {$updateId}");
        //     }
        // }

        // 發送 Markdown 訊息
        $response = $this->apiRequestJson('sendMessage', [
            'chat_id' => 835826701,
            'text' => preg_replace('/^\s+/m', '', "
                2330 台積電
                收盤日\:2021/1/28
                收盤價\:666 \xF0\x9F\x94\xBA\(6\.6%\)
                籌碼\:
                \| 單位\(張\) \| 買賣超 \| 連買連賣 \|
                \| \-\-\- \| \-\-\- \| \-\-\- \|
                \| 外資 \| \-107,225 \| 連4賣 \(\-201,394\) \|
                \| 投信 \| \-8,963 \| 連3買→賣 \(\-8,963\) \|
                \| 自營商 \| \-16,025 \| 連2買→賣 \(\-16,025\) \|
                \| 三大法人 \| \-132,213 \| 連4賣 \(\-223,938\) \|
            "),
            'parse_mode' => 'MarkdownV2',
        ]);
        dd($response);
    }

    /**
     * 通訊軟體機器人接收與回覆訊息
     */
    public function getMessageAndReturn()
    {
        $service = new TelegramService();
        $service->getMessageAndReturn();
    }
}
