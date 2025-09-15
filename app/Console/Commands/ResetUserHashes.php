<?php

namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;

class ResetUserHashes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-user-hashes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $users = User::all();
    foreach ($users as $user) {
        $user->updateValidationHash();
    }

    $this->info('User hashes have been reset.');
}
}
