<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    private static $count = 0;
    public static function bootHasSlug()
    {
        static::creating(function (Model $item) {
            $item->slug = $item->slug
                ?? str($item->{self::slugFrom()})
                    ->append(time() + rand(1, 100) + rand(1, 100))
                    ->slug();
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }
}
