<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\Observers\BrandObserver;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Traits\Models\HasSlug;
use Support\Traits\Traits\Models\HasThumbnail;

/**
 * @method static BrandQueryBuilder|Category query()
 * @method Builder|Category homePage()
 */

#[ObservedBy([BrandObserver::class])]
class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    protected function thumbnailDir(): string
    {
        return 'brands';
    }

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    public function newCollection(array $models = []): BrandCollection
    {
        return new BrandCollection($models);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}