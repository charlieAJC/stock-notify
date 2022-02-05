# 台灣股市股價及三大法人買賣超查詢

在 Telegram 上輸入股票代號，讓機器人告訴你該股票最近一個交易日的收盤表現及近五日的三大法人買賣超

## Requirements

* PHP 7.4
* Laravel 8.74

## Install

laravel vendor

```
$ composer install
```

複製環境變數

```
$ cp .env.example .env
```

將 Telegram bot token 加入 `.env` 中的 `TELEGRAM_BOT_TOKEN`

Telegram bot token 生成請參考 [機器人申請教學](https://ithelp.ithome.com.tw/articles/10262881)

## Guide

輸入以下指令即可使機器人運行

```
$ php artisan bot:process
```

接著在 Telegram 對機器人輸入 `!stock 想要查詢的股票代號` 即可

![](https://i.imgur.com/XGmdbEm.jpeg)

## References

[用 PHP 打造專屬於自己的 Telegram 聊天機器人吧！](https://ithelp.ithome.com.tw/users/20132916/ironman/4418)

[利用Google App Script 實作Telegram Bot](https://ithelp.ithome.com.tw/users/20130283/ironman/3553)

## Notice

本功能未提供歷史股價的資料搜集，可參考我[用 Python 寫的爬蟲](https://github.com/charlieAJC/taiwan-stock-crawler)
