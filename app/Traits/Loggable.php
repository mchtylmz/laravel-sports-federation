<?php

namespace App\Traits;


use Illuminate\Support\Facades\DB;

trait Loggable
{
    protected static string $logTable = 'logs';

    public static function logToDb($model, $logType): void
    {
        if (!auth()->check()) {
            return;
        }

        DB::table(self::$logTable)->insert([
            'user_id'    => auth()->id(),
            'log_date'   => now(),
            'table_name' => $model->getTable(),
            'log_type'   => $logType,
            'ip'         => request()->ip(),
            'data_id'    => $model->id ?? 0,
            'data'       => json_encode($logType == 'create' ? $model : $model->getRawOriginal())
        ]);
    }

    public static function bootLoggable(): void
    {
        self::updated(function ($model) {
            self::logToDb($model, 'edit');
        });


        self::deleted(function ($model) {
            self::logToDb($model, 'delete');
        });


        self::created(function ($model) {
            self::logToDb($model, 'create');
        });
    }
}
