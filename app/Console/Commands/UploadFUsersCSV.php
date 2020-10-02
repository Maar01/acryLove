<?php

namespace App\Console\Commands;

use App\FUser;
use Illuminate\Console\Command;

class UploadFUsersCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Fusers:uploadCSV {csvPath=fusers.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Fusers from a given csv';

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
        $csvPath = $this->argument('csvPath');
        $csvContent = array_map('str_getcsv', file($csvPath));
        array_shift($csvContent);//column titles
        $csvContent = collect($csvContent);
        $csvContent = $csvContent->map(function ($fuser) {
            $userExist = FUser::where('email', $fuser[0])->first();

            if (!$userExist) {
                $newFeuser['email'] = $fuser[0];
                $newFeuser['f_password'] = $fuser[1];
                $newFeuser['email_password'] = $fuser[2];
                $newFeuser['f_profile_name'] = $fuser[3];
                $newFeuser['created_at'] = now();
                return $newFeuser;
            }
        })->filter();

        \DB::table('f_users')->insert($csvContent->toArray());

        return 0;
    }
}
