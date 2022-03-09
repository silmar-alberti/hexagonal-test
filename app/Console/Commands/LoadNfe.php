<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Adapters\Modules\DataLoader\Repository\FindNfeAdapter;
use App\Factories\Http\SendRequestFactory;
use App\Factories\Modules\DataLoader\FindNfeAdapterFactory;
use Core\Modules\DataLoader\Rule\LoadDataRule;
use Core\Modules\DataLoader\UseCase;
use Illuminate\Console\Command;

class LoadNfe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nfe:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command load nfes by api and save on project database';

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

        $useCase = new UseCase(
            new LoadDataRule(
                FindNfeAdapterFactory::create()
            ),
            // new FilterRule(),
            // new SaveDataRule(),
        );


        $useCase->execute();

        return Command::SUCCESS;
    }
}
