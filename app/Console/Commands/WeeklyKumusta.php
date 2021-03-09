<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class WeeklyKumusta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:kumusta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ask users condition automatically every week';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::query()->update(['is_status_answered' => 0]);

        echo 'Weekly Kumusta now running';
    }
}
