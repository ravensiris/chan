<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwaggerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates openapi .yml file';

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
     * @return mixed
     */
    public function handle()
    {
        $openapi = \OpenApi\Generator::scan(['./app']);
        file_put_contents('public/assets/swagger.yml', $openapi->toYaml());

        echo "Wrote to public/assets/swagger.yml\n";
    }
}
