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
            $table->decimal('three_days')->comment('三日');
            $table->decimal('one_week')->comment('一週');
            $table->decimal('two_weeks')->comment('兩週');
            $table->decimal('this_month')->comment('本月');
            $table->decimal('one_month')->comment('一個月');
            $table->decimal('one_quarter')->comment('一季');
            $table->decimal('half_year')->comment('半年');
            $table->decimal('this_year')->comment('今年');
            $table->decimal('one_year')->comment('一年');
            $table->decimal('highest_this_year')->comment('自今年高點');
            $table->decimal('lowest_this_year')->comment('自今年低點');
            $table->decimal('two_years')->comment('兩年');
            $table->decimal('three_years')->comment('三年');
            $table->decimal('five_years')->comment('五年');
            $table->timestamps();

            $table->unique(['stock_symbol', 'crawled_at']);
        });
        DB::statement("ALTER TABLE `stock_performance` comment '股票近期表現 注意數據已去除百分號'");
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
