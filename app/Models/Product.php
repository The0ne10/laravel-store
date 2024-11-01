<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\Traits\Traits\Models\HasSlug;
use Support\Traits\Traits\Models\HasThumbnail;

/**
 * @method static Builder|Category query()
 * @method Builder|Category homePage()
 */
class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    protected $fillable = [
        'title',
        'slug',
        'brand_id',
        'price',
        'thumbnail',
        'on_home_page',
        'sorting',
        'text',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function scopeFiltered(Builder $query)
    {
        $query->when(request('filters.brands'), function (Builder $query) {
            $query->whereIn('brand_id', request('filters.brands'));
        })->when(request('filters.price'), function (Builder $query) {
            $query->whereBetween('price', [
                request('filters.price.from', 0) * 100,
                request('filters.price.to', 100000) * 100,
            ]);
        });
    }

    public function scopeSorted(Builder $query)
    {
        $query->when(request('sort'), function (Builder $query) {
            $column = request()->str('sort');

            if ($column->contains(['price', 'title'])) {
                $direction = $column->contains('-') ? 'desc' : 'asc';

                $query->orderBy((string) $column->remove('-'), $direction);
            }
        });
    }

    public function scopeHomePage(Builder $query): void
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
