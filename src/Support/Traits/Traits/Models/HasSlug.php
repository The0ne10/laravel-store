<?php

namespace Support\Traits\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    private static $count = 0;
    public static function bootHasSlug()
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if(!$this->{$this->slugColumn()}) {
            $slug = $this->slugUnique(
                str($this->{$this->slugFrom()})
                    ->slug()
                    ->value()
            );
        }

        $this->{$this->slugColumn()} = $slug;
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }

    public function slugFrom(): string
    {
        return 'title';
    }

    private function slugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 0;

        while ($this->isSlugExists($slug)) {
            $i++;
            $slug = $originalSlug . '-' . $i;
        }

        return $slug;
    }

    private function isSlugExists(string $slug): bool
    {
        $query = $this->newQuery()
            ->where(self::slugColumn(), $slug)
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->withoutGlobalScopes();

        return $query->exists();
    }
}
