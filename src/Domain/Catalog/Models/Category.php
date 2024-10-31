<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\Observers\CategoryObserver;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Traits\Models\HasSlug;
use Support\Traits\Traits\Models\HasThumbnail;


/**
 * @method static CategoryQueryBuilder|Category query()
 * @method Builder|Category homePage()
 */

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    protected $fillable = [
        'title',
        'slug',
        'on_home_page',
        'sorting',
    ];

    protected function thumbnailDir(): string
    {
        return 'categories';
    }

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }

    public function newCollection(array $models = []): CategoryCollection
    {
        return new CategoryCollection($models);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
