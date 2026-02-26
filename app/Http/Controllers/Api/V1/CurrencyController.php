<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        return CurrencyResource::collection(Currency::all());
    }

    public function store(CurrencyRequest $request)
    {
        return new CurrencyResource(Currency::create($request->validated()));
    }

    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    public function update(CurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->validated());

        return new CurrencyResource($currency);
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        return response()->json();
    }
}
