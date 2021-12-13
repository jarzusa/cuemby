<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Player;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateRowsInDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create players in database';


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
        $inserts=[];
        $page = 1;
        for ($i=1; $i <= 908; $i++) {
            $data = $this->getDataByCurl($i);
            $players = $data['items'];
            // var_dump($players);exit;
            foreach ($players as $key => $value) {
                $this->createRows($value);
            }
        }
        $this->info('The command was successful!');
        return Command::SUCCESS;
    }

    public function getDataByCurl($page)
    {
        $this->line('Extrayendo datos de la API de FIFA..');
        // $this->line(env('API_FIFA').'?page='.$page);
        // exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('API_FIFA').'?page='.$page);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        $data = json_decode($data, true);

        return $data;
    }

    public function createRows($players)
    {
        try {
            $exist = DB::table('players')
                    ->select('id', 'firstname', 'lastname')
                    ->where('commonName', $players["name"])
                    ->where('age', $players["age"])
                    ->get();

            if ($exist->isEmpty()) {
                $this->line('Creando registros..');
                Player::create([
                    "commonName" => $players["name"],
                    "firstname" => $players["firstName"],
                    "lastname" => $players["lastName"],
                    "league" => $players["league"]["name"],
                    "nation" => $players["nation"]["name"],
                    "club" => $players["club"]["name"],
                    "position" => $players["position"],
                    "age" => $players["age"]
                ]);
            } else {
                $this->line('Ya existe!!.');
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $this->newLine(3);
    }
}
