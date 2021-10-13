<?php


namespace Igorhaf\LaravelSqlMigrations\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Laravel\Telescope\Telescope;

class SqlMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sql-migration:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore all migrations';

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
        // todo: check if telescope is installed
        Telescope::stopRecording();
        ini_set('memory_limit', '-1');
        \DB::unprepared('CREATE TABLE IF NOT EXISTS sql_migrations (
  id  serial  PRIMARY KEY,
  migration  varchar,
  batch  int
);');
        $files = scandir(config('sqlmigrations.path'));

        foreach ($files as $key => $file) {

            if (file_exists(config('sqlmigrations.path').'/'.$file)) {

                $info = pathinfo($file);

                if ($info["extension"] == "sql") {
                    $name = str_replace('.sql', '',  $file);
                    $count_migration = \DB::table(config('database.connections.'.config('database.default'))['schema'].'.sql_migrations')
                        ->where('migration', '=', $name)
                        ->count();

                    if(!$count_migration) {
                        $startTime = microtime(true);
                        try {

                            if(!empty(file_get_contents( config('sqlmigrations.path').'/'.$file))){
                                \DB::unprepared( file_get_contents( config('sqlmigrations.path').'/'.$file));
                                $runTime = round(microtime(true) - $startTime, 2);
                                $this->info("<comment>Migrating:</comment> {$name} ({$runTime} seconds)");
                                \DB::unprepared("INSERT INTO ".config('database.connections.'.config('database.default'))['schema'].".sql_migrations (migration, batch) VALUES ('$name', '$key');");
                            }else{
                                $this->warn('Empty file : '.$file.' skipping');
                            }

                        }catch (QueryException $e){
                            $this->warn(substr($e->getMessage(),0,400));
                            break;
                        }
                    }else{
                        $this->info("No migrations to run!");
                        break;
                    }


                }
            }
        }
        Telescope::startRecording();
    }
}
