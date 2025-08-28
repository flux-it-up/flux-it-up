<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FluxItUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fluxitup:build {name} {--migration} {--seed} {--factory} {--pest}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds model and CRUD livewire components';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $options = $this->options();

        $this->info('Running Artisan commands...');

        $this->info("Creating model: {$name}...");
        $this->call('make:model', [
            'name' => $name,
            '--migration' => $options['migration'],
            '--seed' => $options['seed'],
            '--factory' => $options['factory'],
            '--pest' => $options['pest'],
        ]);
        $this->info('Model created ✅');

        $this->call('make:livewire', [
            'name' => $name.'/Index',
        ]);
        $this->call('make:livewire', [
            'name' => $name.'/Create',
        ]);
        $this->call('make:livewire', [
            'name' => $name.'/Update',
        ]);
        $this->call('make:livewire', [
            'name' => $name.'/Delete',
        ]);

        $this->info('All done ✅');
    }
}
