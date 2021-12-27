<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStockPerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_performance', function (Blueprint $table) {
            $table->id();
            $table->string('stock_symbol', 50)->index()->comment('股票代號');
            $table->date('crawled_at')->comment('爬蟲資料建立時間');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `stock_performance` comment '股票近期表現'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_performance');
    }
}
