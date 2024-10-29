<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @method static Builder|Category query()
 * @method Builder|Category homePage()
 */
class Category extends Model
{
    use HasFactory;
    use HasSlug;
    protected $fillable = [
        'title',
        'slug',
        'on_home_page',
        'sorting',
    ];

    public function scopeHomePage(Builder $query): Builder
    {
        return $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
