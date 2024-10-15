<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:refresh';
    private array $deleteDirectory = [
        'Brands',
        'Products'
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
        foreach ($this->deleteDirectory as $directory) {
            Storage::deleteDirectory($directory);
        }

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);
    }
}
