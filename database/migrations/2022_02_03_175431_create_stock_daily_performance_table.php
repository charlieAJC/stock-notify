<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStockDailyPerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_daily_performance', function (Blueprint $table) {
            $table->id();
            $table->string('stock_symbol', 50)->comment('股票代號');
            $table->date('record_date')->comment('資料日期');
            $table->string('period', 10)->comment('逐日/週/月/季 day/week/month/quarter');
            $table->integer('foreign')->comment('外資買賣超張數');
            $table->integer('investment_trust')->comment('投信買賣超張數');
            $table->integer('dealer')->comment('自營買賣超張數');
            $table->integer('total')->comment('三大買賣超張數');
            $table->string('foreign_percent', 10)->comment('外資籌碼佔比');
            $table->string('change_percent', 10)->comment('漲跌幅');
            $table->integer('volume')->comment('成交量');
            // $table->timestamps();

            $table->unique(['stock_symbol', 'record_date', 'period']);
        });
        DB::statement("ALTER TABLE `stock_daily_performance` comment '法人逐日買賣超'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_daily_performance');
    }
}
