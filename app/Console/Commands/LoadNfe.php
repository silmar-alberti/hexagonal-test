<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Adapters\Modules\DataLoader\Repository\FindNfeAdapter;
use App\Factories\Http\SendRequestFactory;
use App\Modules\DataLoader\Repository\FindNfeRepository;
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

        $useCase = new UseCase(
            new LoadDataRule(
                new FindNfeAdapter(
                    SendRequestFactory::create(),
                    'https://sandbox-api.arquivei.com.br',
                    '329ea218aa65778fad452643fe4d9bdeba0673e6',
                    '39020d7f2ff4485632166f578d486f0ab74174e0',
                )
            ),
            // new FilterRule(),
            // new SaveDataRule(),
        );


        $useCase->execute();

        return Command::SUCCESS;
    }
}
