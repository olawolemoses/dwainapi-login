<?php

namespace Dwaincore\Authmgt\Commands;

use Illuminate\Console\Command;

class AuthmgtCommand extends Command
{
    public $signature = 'authmgt';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');

    }
}
