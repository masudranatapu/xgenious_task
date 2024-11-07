<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    //
    public function index()
    {
        try {
            $states = State::query()
                ->get();
            return view('city.index', compact('states'));
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }

    public function cityData()
    {
        try {
            $cities = City::query()
                ->get();

            $html = view('city.table_data', compact('cities'))->render();

            return response()->json($html);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }
    public function store(CityRequest $request)
    {
        try {
            DB::beginTransaction();

            $city = new City();
            $city->state_id = $request->state_id;
            $city->city_name = $request->city_name;
            $city->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data Successfully Created',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }



    public function edit($id)
    {
        try {
            $city = City::query()
                ->findOrFail($id);

            $states = State::query()
                ->get();


            $html = view('city.edit', compact('city', 'states'))->render();

            return response()->json($html);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }


    public function update(CityRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $city = City::query()
                ->findOrFail($id);
            $city->state_id = $request->state_id;
            $city->city_name = $request->city_name;
            $city->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data Successfully Updated',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $city = City::query()
                ->findOrFail($id);

            $city->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data Successfully Deleted',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }
}
