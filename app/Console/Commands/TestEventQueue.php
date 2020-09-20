<?php

namespace App\Console\Commands;

use App\Events\TestEvent;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Tenancy\Facades\Tenancy;

class TestEventQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $t = Tenant::first();
        Tenancy::setTenant($t);

        $u = User::first();

        event(new TestEvent($u));

        return 0;
    }
}
