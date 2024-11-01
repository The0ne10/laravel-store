<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:refresh';
    private array $deleteDirectory = [
        'brands',
        'products'
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storage = Storage::disk('images');
        foreach ($this->deleteDirectory as $directory) {
            $storage->deleteDirectory($directory);
        }

        $this->call('cache:clear');
        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);
    }
}
