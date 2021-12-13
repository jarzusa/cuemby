<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPlayers(Request $request)
    {
        $player = $request->get('player');
        try {
            if (isset($player)) {
                $players = DB::table('players')
                        ->selectRaw('*')
                        ->whereRaw("commonName LIKE '%" . $player . "%'")
                        ->get();
            } else {
                $players = DB::table('players')
                        ->selectRaw('*')
                        ->get();
            }
            return response()->json([
                'success' => true,
                'data' => $players,
            ]);
        } catch (Exception $e) {
            error_log($e, 0);
            return response()->json([
                'success'  => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $player,
            ]);
        } catch (Exception $e) {
            error_log($e, 0);
            return response()->json([
                'success'  => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function GetPlayersByTeam(Request $request)
    {
        $team = $request->get('team');
        try {
            if (isset($team)) {
                $players = DB::table('players')
                        ->selectRaw('*')
                        ->whereRaw("club LIKE '%" . $team . "%'")
                        ->get();
            } else {
                $players = DB::table('players')
                        ->selectRaw('*')
                        ->get();
            }
            return response()->json([
                                'success' => true,
                                'data' => $players,
                            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'  => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        //
    }
}
