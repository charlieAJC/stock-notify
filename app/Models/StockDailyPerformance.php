<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDailyPerformance extends Model
{
    protected $table = 'stock_daily_performance';

    protected $fillable = [
        'stock_symbol',
        'record_date',
        'period',
        'foreign',
        'investment_trust',
        'dealer',
        'total',
        'foreign_percent',
        'change_percent',
        'volume',
    ];
}
