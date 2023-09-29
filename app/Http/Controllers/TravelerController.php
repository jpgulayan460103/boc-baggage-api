<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelerRequest;
use App\Models\Traveler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TravelerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();
        $query = Traveler::query(20);

        $filters = $request->filters;
        $sorters = $request->sorters;
        $sorterOrders = $request->sorterOrders;

        if(isset($filters['last_name'])){
            $last_name = $filters['last_name'];
            $query->where('last_name', 'like', "%$last_name%");
        }
        if(isset($filters['first_name'])){
            $first_name = $filters['first_name'];
            $query->where('first_name', 'like', "%$first_name%");
        }
        if(isset($filters['middle_name'])){
            $middle_name = $filters['middle_name'];
            $query->where('middle_name', 'like', "%$middle_name%");
        }
        if(isset($filters['remarks'])){
            $remarks = $filters['remarks'];
            $query->where('remarks', 'like', "%$remarks%");
        }

        if(isset($filters['last_departure_date']) && $filters['last_departure_date'] != []){
            if(isset($filters['last_departure_date'][0]) && isset($filters['last_departure_date'][1])){
                $query->whereBetween('last_departure_date', [
                    Carbon::parse($filters['last_departure_date'][0]),
                    Carbon::parse($filters['last_departure_date'][1]),
                ]);
            }elseif(!isset($filters['last_departure_date'][0]) && isset($filters['last_departure_date'][1])){
                $query->where('last_departure_date', '<=', Carbon::parse($filters['last_departure_date'][1]));
            }elseif(isset($filters['last_departure_date'][0]) && !isset($filters['last_departure_date'][1])){
                $query->where('last_departure_date', '>=', Carbon::parse($filters['last_departure_date'][0]));
            }
        }

        if(isset($filters['created_at']) && $filters['created_at'] != []){
            if(isset($filters['created_at'][0]) && isset($filters['created_at'][1])){
                $query->whereBetween('created_at', [
                    Carbon::parse($filters['created_at'][0]),
                    Carbon::parse($filters['created_at'][1])->addDay()->subSecond(),
                ]);
            }elseif(!isset($filters['created_at'][0]) && isset($filters['created_at'][1])){
                $query->where('created_at', '<=', Carbon::parse($filters['created_at'][1])->addDay()->subSecond());
            }elseif(isset($filters['created_at'][0]) && !isset($filters['created_at'][1])){
                $query->where('created_at', '>=', Carbon::parse($filters['created_at'][0]));
            }
        }

        if(isset($sorterOrders) && $sorterOrders != []){
            foreach ($sorterOrders as $field) {
                if(isset($sorters[$field])){
                    $order = $sorters[$field];
                    $query->orderBy($field, $order);
                }
            }
        }else{
            $query->orderBy('id', 'desc');
        }

        if($request->searchQuery){
            $keywords = explode(" ", $request->searchQuery);
            if($keywords != []){
                $query->where(function($subQuery) use ($keywords){
                    foreach ($keywords as $keyword) {
                        $subQuery->orWhere('last_name', 'like', "%$keyword%");
                        $subQuery->orWhere('first_name', 'like', "%$keyword%");
                        $subQuery->orWhere('middle_name', 'like', "%$keyword%");
                    }
                });
            }
        }
        

        $travelers = $query->paginate(20);
        return [
            'travelers' => $travelers,
            'query' => DB::getQueryLog(),
        ];
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
    public function store(TravelerRequest $request)
    {
        return Traveler::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Traveler  $traveler
     * @return \Illuminate\Http\Response
     */
    public function show(Traveler $traveler)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Traveler  $traveler
     * @return \Illuminate\Http\Response
     */
    public function edit(Traveler $traveler)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Traveler  $traveler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $traveler = Traveler::findOrFail($id);
        $traveler->update($request->all());

        return $traveler;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Traveler  $traveler
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Traveler::findOrFail($id)->delete();
    }
}
