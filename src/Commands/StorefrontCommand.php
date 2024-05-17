<?php

namespace Biztory\Storefront\Commands;

use Illuminate\Console\Command;

class StorefrontCommand extends Command
{
    public $signature = 'storefront';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
