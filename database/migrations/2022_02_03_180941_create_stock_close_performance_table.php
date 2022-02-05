<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStockClosePerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_close_performance', function (Blueprint $table) {
            $table->id();
            $table->string('stock_symbol', 50)->comment('股票代號');
            $table->date('close_date')->comment('收盤日');
            $table->decimal('price')->comment('股價');
            $table->decimal('change')->comment('漲跌');
            $table->string('change_percent', 10)->comment('漲跌百分比');
            // $table->timestamps();

            $table->unique(['stock_symbol', 'close_date']);
        });
        DB::statement("ALTER TABLE `stock_close_performance` comment '每日收盤表現'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_close_performance');
    }
}
