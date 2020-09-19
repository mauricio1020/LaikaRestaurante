<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveStoreRequest;
use App\Reserve;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    /**
     * @var Reserve
     */
    private $reserve;

    public function __construct(Reserve $reserve)
    {
        $this->reserve = $reserve;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReserveStoreRequest $request)
    {
        $this->reserve->newQuery()->create($request->all());
    }
}
