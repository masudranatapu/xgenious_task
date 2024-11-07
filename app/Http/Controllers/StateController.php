<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    public function index()
    {
        try {
            $countries = Country::query()
                ->get();
            return view('state.index', compact('countries'));
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }
    public function stateData()
    {
        try {
            $states = State::query()
                ->with([
                    'country',
                    'cities'
                ])
                ->get();

            $html = view('state.table_data', compact('states'))->render();

            return response()->json($html);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }

    public function store(StateRequest $request)
    {
        try {
            DB::beginTransaction();

            $state = new State();
            $state->country_id = $request->country_id;
            $state->state_name = $request->state_name;
            $state->save();

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
            $state = State::query()
                ->findOrFail($id);

            $countries = Country::query()
                ->get();


            $html = view('state.edit', compact('state', 'countries'))->render();

            return response()->json($html);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }

    public function update(StateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $state = State::query()
                ->findOrFail($id);
            $state->country_id = $request->country_id;
            $state->state_name = $request->state_name;
            $state->save();

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

            $state = State::query()
                ->with([
                    'cities'
                ])
                ->findOrFail($id);

            if ($state->cities?->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sorry state has dependency with cities. You can not delete state',
                ]);
            }

            $state->delete();

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
