<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::latest()->paginate(10);

        return FoodResource::collection($foods);
    }

    public function store(StoreFoodRequest $request)
    {
        $food = Food::create($request->validated());

        return new FoodResource($food);
    }

    public function show(Food $food)
    {
        return new FoodResource($food);
    }

    public function update(UpdateFoodRequest $request, Food $food)
    {
        $food->update($request->validated());

        return new FoodResource($food);
    }

    public function destroy(Food $food)
    {
        $food->delete();

        return response()->json([
            'message' => 'Food deleted successfully'
        ], 200);
    }
}
