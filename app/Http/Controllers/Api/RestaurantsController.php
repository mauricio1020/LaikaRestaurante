<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Resources\Restaurant as RestaurantResource;

class RestaurantsController extends Controller
{
    /**
     * @var Restaurant
     */
    private $restaurant;

    /**
     * RestaurantsController constructor.
     *
     * @param Restaurant $restaurant
     */
    public function __construct(Restaurant $restaurant)
    {
        return $this->restaurant = $restaurant;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->restaurant->newQuery()->with("reservation")->search($request)->paginate();

        return RestaurantResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->restaurant->newQuery()->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RestaurantResource
     */
    public function show($id)
    {
        return new RestaurantResource($this->restaurant->newQuery()->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->restaurant->newQuery()->find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->restaurant->newQuery()->find($id)->delete();
    }
}
