<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMainProfitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_profit', function (Blueprint $table) {
            $table->id();
            $table->string('stock_symbol', 50)->index()->comment('股票代號，大盤為0');
            $table->date('crawled_at')->comment('爬蟲資料建立時間');
            $table->integer('order')->comment('獲利排名');
            $table->string('brokerage', 50)->comment('券商(分點)名稱');
            $table->decimal('performance')->comment('績效(%)');
            $table->decimal('income')->comment('總損益(千)');
            $table->integer('over_buy')->comment('買賣超');
            $table->decimal('average_price')->comment('均價');
            $table->timestamps();

            $table->unique(['stock_symbol', 'crawled_at', 'order']);
        });
        DB::statement("ALTER TABLE `main_profit` comment '券商分點績效/獲利分析'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_profit');
    }
}
