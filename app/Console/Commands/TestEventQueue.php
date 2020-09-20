<?php

namespace App\Console\Commands;

use App\Events\TestEvent;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
        $t = Tenant::query()->first();

        if ( ! $t) {
            $t = new Tenant();
            $t->save();
        }

        Tenancy::setTenant($t);

        $u = User::query()->first();
        if ( ! $u) {
            $u           = new User();
            $u->name     = "Rocky";
            $u->email    = "wpkpda@gmail.com";
            $u->password = Hash::make(Str::random(8));
            $u->save();
        }

        event(new TestEvent($u));

        return 0;
    }
}
