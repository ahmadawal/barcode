<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cable;

class CableController extends Controller
{
    public function getAll()
    {
        return response()->json(Cable::all()->cursor());
    }

    public function getOP($id)
    {
        /*
        $response = $client->request('GET', '/api/cable', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json',
            ],
        ]);
        */
        // $response = $client->request('GET', '/api/cables?api_token='.$token);
        $data = Cable::where('OPNo', $id)->cursor();
        // $data = $id;
        return response()->json(['data' => $data]);
    }
}
