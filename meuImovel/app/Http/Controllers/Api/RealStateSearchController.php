<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\RealState;
use App\Repository\RealStateRepository;
use Illuminate\Http\Request;

class RealStateSearchController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //1 - Maranhão ; 1 - São Luiz
        //2 - Goias ; 2 - Goiânia
        //2 - Goias ; 3 - Anápolis
        /*
        dd($this->realState->whereHas('address', function ($q) {
            $q->where('state_id', 2)
                ->where('city_id', 2);
        })->get());
        */

        //PASSEI OS COMANDOS ABAIXO PARA DENTRO DO RealStateRepository.php
        /*
        return $this->realState->whereHas('address', function ($q) {
            $q->where('state_id', 2)
                ->where('city_id', 2);
        })->get();
        */

        //$realState = $this->realState->paginate(10);

        $repository = new RealStateRepository($this->realState);

        if ($request->has('coditions')) {
            $repository->selectCoditions($request->get('coditions'));
        }

        if ($request->has('fields')) {
            $repository->selectFilter($request->get('fields'));
        }

        $repository->setLocation($request->all('state', 'city'));

        return response()->json([
            'data' => $repository->getResult()->paginate(10)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $realState = $this->realState->with('address')->with('photos')->findOrFail($id);

            return response()->json([
                'data' => $realState
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
