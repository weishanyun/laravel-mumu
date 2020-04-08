<?php

namespace App\Console\Commands;

use App\Models\Test;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tool:test';

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
     * @return mixed
     */
    public function handle()
    {
//        for ($i=1;$i<10000;$i++)
//        {
//            $model = new Test();
//            $model->add();
//        }
        $model = new Test();
        $list = $model->getList();

        dd($list);
    }
}
