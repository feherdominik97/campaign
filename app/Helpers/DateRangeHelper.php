<?php
namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DateRangeHelper {
    public static function appendRangeFilter(Builder|HasMany $builder, $start, $end): Builder|HasMany
    {
        switch (true) {
            case ($start && $end):
                $builder->whereBetween('date', [$start, $end]);
                break;
            case $start:
                $builder->where('date', '>=', $start);
                break;
            case $end:
                $builder->where('date', '>=', $end);
                break;
        }

        return $builder;
    }
}
