<?php

namespace App\Http\Controllers;

use App\Models\Finding;
use App\Models\Traveler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FindingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $traveler_id)
    {
        try {
            DB::beginTransaction();
            $traveler = Traveler::findOrFail($traveler_id);
            if($request->customFindings && $request->customFindings != array()){
                $traveler->customFindings()->delete();
                $customFindings = $request->customFindings;
                foreach ($customFindings as $customFinding) {
                    $traveler->customFindings()->create($customFinding);
                }
            }
            DB::commit();
            return [
                'traveler' => $traveler
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finding  $finding
     * @return \Illuminate\Http\Response
     */
    public function show(Finding $finding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finding  $finding
     * @return \Illuminate\Http\Response
     */
    public function edit(Finding $finding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finding  $finding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Finding $finding)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finding  $finding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Finding $finding)
    {
        //
    }
}
