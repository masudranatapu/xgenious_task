<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public function index()
    {
        return view('country.index');
    }

    public function countryData()
    {
        try {
            $countries = Country::query()
                ->with([
                    'state'
                ])
                ->get();

            $html = view('country.table_data', compact('countries'))->render();

            return response()->json($html);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }

    public function store(CountryRequest $request)
    {
        try {
            DB::beginTransaction();

            $country = new Country();
            $country->country_name = $request->country_name;
            $country->save();

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
            $countries = Country::query()
                ->with([
                    'state'
                ])
                ->findOrFail($id);

            $html = view('country.edit', compact('countries'))->render();

            return response()->json($html);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }

    public function update(CountryRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $country = Country::query()
                ->findOrFail($id);
            $country->country_name = $request->country_name;
            $country->save();

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

            $country = Country::query()
                ->with([
                    'state'
                ])
                ->findOrFail($id);

            if ($country->state?->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sorry country has dependency with state. You can not delete country',
                ]);
            }

            $country->delete();

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
