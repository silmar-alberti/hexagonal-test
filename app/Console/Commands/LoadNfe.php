<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Adapters\Modules\DataLoader\IntegrationStatusAdapter;
use App\Adapters\Modules\DataLoader\NfeExistsAdapter;
use App\Adapters\Modules\DataLoader\SaveNfeAdapter;
use App\Factories\Modules\DataLoader\FindExternalNfeAdapterFactory;
use Core\Modules\DataLoader\Rule\FilterRule;
use Core\Modules\DataLoader\Rule\LoadDataRule;
use Core\Modules\DataLoader\Rule\SaveDataRule;
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
    public function __construct(
        private SaveNfeAdapter $saveNfeAdapter,
        private NfeExistsAdapter $nfeExistsAdapter,
        private IntegrationStatusAdapter $integrationStatusAdapter,
    ) {
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
                FindExternalNfeAdapterFactory::create(),
                $this->integrationStatusAdapter,
            ),
            new FilterRule($this->nfeExistsAdapter),
            new SaveDataRule($this->saveNfeAdapter),
        );


        $useCase->execute();

        return Command::SUCCESS;
    }
}
