<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockClosePerformance extends Model
{
    protected $table = 'stock_close_performance';

    protected $fillable = [
        'stock_symbol',
        'close_date',
        'price',
        'change',
        'change_percent',
    ];

    protected $casts = [
        'price' => 'float',
        'change' => 'float',
    ];

    /**
     * 關聯法人逐日買賣超
     */
    public function stockDailyPerformance()
    {
        return $this->hasMany('App\Models\StockDailyPerformance', 'stock_symbol', 'stock_symbol');
    }
}
