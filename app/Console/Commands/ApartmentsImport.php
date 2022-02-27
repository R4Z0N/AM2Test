<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;

class ApartmentsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apartments:import {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import apartments from json file';

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
        $file = "/database/import/{$this->argument('fileName')}.json";
        if(Storage::disk('local')->exists($file)) {
            $this->line("Starting import from {$file} file.");

            $path = storage_path() . "/app/database/import/{$this->argument('fileName')}.json";


            $json = json_decode(file_get_contents($path), true);

            foreach($json as $value) {
                $this->line("Importing object. {$value['name']}");
                $apartment = Apartment::firstWhere('name', $value['name']);
                if($apartment) {
                    $this->error("#{$value['id']} {$value['name']} it already exists.");
                } else {
                    $apartment = new Apartment($value);
                    if($apartment->save())
                        $this->info("{$value['name']} has been added.");
                    else
                        $this->error("Error entering object.");
                }
            }

        } else {
            $this->error("{$file} does not exist.");
        }
        return 0;
    }
}
