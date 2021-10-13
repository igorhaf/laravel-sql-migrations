<?php


namespace Igorhaf\LaravelSqlMigrations\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SqlMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sql-migration:create {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a .sql migration file';

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
        $time = substr(time(), 0,-3);
        $date = Carbon::parse(now())->format('Y_m_d_'.$time.'_');
        try {
            fopen(config('sqlmigrations.path').'/'.$date.$this->argument('filename').'.sql', "w");
            $this->info("Migration created successful!".$date.$this->argument('filename').'.sql');
        }catch (\Exception $exception){
            $exception->getMessage();
        }


    }
}
