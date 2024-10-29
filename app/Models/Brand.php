<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder|Category query()
 * @method Builder|Category homePage()
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    public function scopeHomePage(Builder $query): Builder
    {
        return $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
