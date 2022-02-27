<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;


class ApartmentsExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apartments:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all apartments to json file';

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
        try {
            $apartments = Apartment::all();
            $this->line("Apartments exporting..");
            $file = "/database/export/apartments-".time().".json";
            Storage::disk('local')->put($file, $apartments->toJson());
            $this->info("Apartments exported to {$file} file.");
        } catch (Exception) {
            $this->error("There was a problem with the export of the apartments.");
        }
    }
}
