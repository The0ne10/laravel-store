<?php

namespace Support\Traits\Traits\Models;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{
    abstract protected function thumbnailDir(): string;
    public function makeThumbnail(string $size, string $method = 'resize'): string
    {
        $fileName = File::basename($this->{$this->thumbnailColumn()});

        if (!$fileName) {
            $fileName = 'someText';
        }

        return route('thumbnail', [
            'size' => $size,
            'dir' => $this->thumbnailDir(),
            'method' => $method,
            'file' => $fileName,
        ]);
    }

    protected function thumbnailColumn(): string
    {
        return 'thumbnail';
    }
}
