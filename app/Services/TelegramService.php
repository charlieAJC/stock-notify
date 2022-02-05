<?php

namespace App\Services;

use App\Repositories\StockClosePerformanceRepository;
use App\Traits\TelegramTrait;
use Exception;

class TelegramService
{
    use TelegramTrait;

    /**
     * 通訊軟體機器人接收與回覆訊息
     */
    public function getMessageAndReturn()
    {
        $updateId = 0;
        while (true) {
            $responses = $this->apiRequest('getUpdates', [
                'offset' => $updateId,
                'timeout' => 30,
            ]);
            // dump($responses);
            collect($responses['result'])->map(function ($response) {
                // dump($this->processMessage($response['message']));
                info($response['message']['text']);
                $this->processMessage($response['message']);
            });
            if ($responses['result']) {
                $lastArrayKey = array_key_last($responses['result']);
                $updateId = $responses['result'][$lastArrayKey]['update_id'] + 1;
                // dump("new update_id is: {$updateId}");
                info("new update_id is: {$updateId}");
            }
        }
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
        $responseText = '';
        if (stripos($text, '!stock') === 0) {
            if (preg_match('/^!stock (\d{4})$/', $text, $stockSymbol)) {
                $responseText = $this->getStockPerformance($stockSymbol[1]);
                return $this->apiRequestJson('sendMessage', [
                    'chat_id' => $chatId,
                    // 'reply_to_message_id' => $messageId,
                    'text' => $responseText,
                    'parse_mode' => 'HTML',
                ]);
            } else {
                $responseText = 'hmmm... can not find the stock symbol';
            }
        } elseif (in_array($text, ['Hello', 'Hi'])) {
            $responseText = 'Nice to meet you :D';
        } elseif (stripos($text, '!stop') === 0) {
            // stop now
            $responseText = 'Okay, bye!';
        } else {
            $responseText = 'Cool!';
        }
        return $this->apiRequest('sendMessage', [
            'chat_id' => $chatId,
            'reply_to_message_id' => $messageId,
            'text' => $responseText,
        ]);
    }

    /**
     * 以股票代號取得股票資訊並構成回傳訊息
     *
     * @param string $stockSymbol
     * @return string
     */
    public function getStockPerformance(string $stockSymbol): string
    {
        $companyName = config('stocksymbol.' . $stockSymbol);
        $responseText = '';
        if ($companyName === null) {
            return 'stock symbol do not correspond any company';
        }
        $responseText .= "{$stockSymbol} {$companyName} \n";

        $stockClosePerformanceRepository = new StockClosePerformanceRepository();
        try {
            $data = $stockClosePerformanceRepository->getLastestInfo($stockSymbol);
        } catch (Exception $e) {
            return 'Sorry, something went wrong while getting stock data';
        }
        if ($data === null) {
            return 'Sorry, we have not record this stock performance';
        }
        $responseText .= '收盤日: ' . $data->close_date . " \n";
        $symbol = '';
        // 漲跌emoji https://apps.timwhitlock.info/emoji/tables/unicode
        // 漲 \xF0\x9F\x94\xBA
        // 跌 \xF0\x9F\x94\xBB
        if ($data->change > 0) {
            $symbol = "\xF0\x9F\x94\xBA";
        } elseif ($data->change < 0) {
            $symbol = "\xF0\x9F\x94\xBB";
        } else {
            $symbol = '-';
        }
        $responseText .= "收盤價: {$data->price} {$symbol}" . abs($data->change) .
        '(' . preg_replace('/-/', '', $data->change_percent) . ") \n";

        $tableString = "\n";
        collect($data->stockDailyPerformance)->map(function ($performance) use (&$tableString) {
            $tableString .= substr($performance->record_date, 5) . '  '
            . str_pad(strval($performance->foreign), 8)
            . str_pad(strval($performance->investment_trust), 7)
            . str_pad(strval($performance->dealer), 7)
            . str_pad(strval($performance->total), 8)
            . $performance->volume;

            $tableString .= "\n";
        });
        $responseText .= preg_replace(
            '/^\s+/m',
            '',
            '籌碼:
            <pre>
            日期    外資    投信    自營    合計    成交量
            -----  ------  -----  -----  ------  -----' .
            $tableString .
            '</pre>'
        );
        return $responseText;
    }
}
