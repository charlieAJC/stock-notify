<?php

namespace App\Repositories;

use App\Models\StockClosePerformance;

class StockClosePerformanceRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new StockClosePerformance();
        $this->model = $this->model->query();
    }

    /**
     * 取得最近一交易日的收盤價格與近五日的三大法人籌碼買賣超
     *
     * @param string $stockSymbol 股票代號
     * @return App\Models\StockClosePerformance
     */
    public function getLastestInfo(string $stockSymbol)
    {
        return $this->model->where('stock_symbol', $stockSymbol)
            ->orderByDesc('close_date')
            ->with(['stockDailyPerformance' => function ($query) {
                $query->orderByDesc('record_date')->take(5);
            }])
            ->first();
    }
}
