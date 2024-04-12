<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateFreshAndSeed extends Command
{
    protected $signature = 'migrate:freshandseed';

    protected $description = 'Migrate fresh and seed the database';

    public function handle()
    {
        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);
    }
}
