<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelerRequest;
use App\Models\Traveler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TravelerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $isExport = false)
    {
        DB::enableQueryLog();
        $query = Traveler::with(['customFindings', 'companions']);

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
        if(isset($filters['airline'])){
            $airline = $filters['airline'];
            $query->where('airline', 'like', "%$airline%");
        }
        if(isset($filters['flight_number'])){
            $flight_number = $filters['flight_number'];
            $query->where('flight_number', 'like', "%$flight_number%");
        }
        if(isset($filters['traveler_type'])){
            $traveler_type = $filters['traveler_type'];
            $query->where('traveler_type', 'like', "%$traveler_type%");
        }
        if(isset($filters['travel_purpose'])){
            $travel_purpose = $filters['travel_purpose'];
            $query->where('travel_purpose', 'like', "%$travel_purpose%");
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

        if(isset($filters['arrival_date']) && $filters['arrival_date'] != []){
            if(isset($filters['arrival_date'][0]) && isset($filters['arrival_date'][1])){
                $query->whereBetween('arrival_date', [
                    Carbon::parse($filters['arrival_date'][0]),
                    Carbon::parse($filters['arrival_date'][1]),
                ]);
            }elseif(!isset($filters['arrival_date'][0]) && isset($filters['arrival_date'][1])){
                $query->where('arrival_date', '<=', Carbon::parse($filters['arrival_date'][1]));
            }elseif(isset($filters['arrival_date'][0]) && !isset($filters['arrival_date'][1])){
                $query->where('arrival_date', '>=', Carbon::parse($filters['arrival_date'][0]));
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
                        $subQuery->where('fullname', 'like', "%$keyword%");
                    }
                });
                $query->orWhereHas('companions', function($subQuery) use ($keywords){
                    foreach ($keywords as $keyword) {
                        $subQuery->where('fullname', 'like', "%$keyword%");
                    }
                });
            }
        }
        

        $travelers = $isExport ? $query->paginate(2000) : $query->paginate(20);
        return [
            'travelers' => $travelers->toArray(),
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
        try {
            DB::beginTransaction();
            $traveler = Traveler::create($request->all());
            if($request->customFindings && $request->customFindings != array()){
                $customFindings = $request->customFindings;
                foreach ($customFindings as $customFinding) {
                    $traveler->customFindings()->create($customFinding);
                }
            }
            if($request->companions && $request->companions != array()){
                $companions = $request->companions;
                foreach ($companions as $companion) {
                    $traveler->companions()->create($companion);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
    public function update(TravelerRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $traveler = Traveler::findOrFail($id);
            $traveler->update($request->all());
            $traveler->customFindings()->delete();
            if($request->customFindings && $request->customFindings != array()){
                $customFindings = $request->customFindings;
                foreach ($customFindings as $customFinding) {
                    $traveler->customFindings()->create($customFinding);
                }
            }

            $traveler->companions()->delete();
            if($request->companions && $request->companions != array()){
                $companions = $request->companions;
                foreach ($companions as $companion) {
                    $traveler->companions()->create($companion);
                }
            }
            DB::commit();
            return $traveler;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

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

    public function createExport(Request $request)
    {
        $datetime = Carbon::now();
        $filename = 'export-travelers-'.$datetime->toDateString().'-'.$datetime->format('H-i-s').'.csv';
        $file_location = "exported/$filename";
        $temp_local_file_location = public_path("tmp/$filename");
        $file = fopen($temp_local_file_location, 'w+');

        $headers = [
            'Surname',
            'First Name',
            'Middle Name',
            'Gender',
            'Birthdate',
            'Citizenship',
            'Passport Number',
            'Place Issued',
            'Date Issued',
            'Occupation',
            'Company',
            'Contact Number',
            'Address in the PH',
            'Last Departure Date',
            'Country Origin',
            'Airline',
            'Flight Number',
            'Date of Arrival',
            'Remarks',
            'Findings',
            'Amount',
        ];

        fputcsv($file, $headers);
        fclose($file);
        Storage::put($file_location, file_get_contents($temp_local_file_location));

        if (file_exists($temp_local_file_location)) {
            unlink($temp_local_file_location);
        }

        $travelers = (array)$this->index($request, $isExport = true);

        return [
            'total_pages' => $travelers['travelers']['last_page'],
            'filename' => $filename,
            'file_location' => $file_location,
        ];
    }

    public function writeExport(Request $request)
    {
        $filename = $request->filename;
        $file_location = $request->file_location;

        $temp_filename = (string) Str::uuid().'.csv';
        $temp_local_file_location = public_path("tmp/$temp_filename");

        if (! file_exists($temp_local_file_location)) {
            $file = Storage::get($file_location);
            file_put_contents($temp_local_file_location, $file);
        }

        $filters = [];

        $file = fopen($temp_local_file_location, 'a+');

        $for_export = [];

        $travelers = (array)$this->index($request, $isExport = true);

        foreach ($travelers['travelers']['data'] as $traveler) {
            $export_data = [
                $traveler['last_name'],
                $traveler['first_name'],
                $traveler['middle_name'],
                $traveler['gender'],
                $traveler['birth_date'],
                $traveler['citizenship'],
                $traveler['passport_number'],
                $traveler['passport_place_issued'],
                $traveler['passport_date_issued'],
                $traveler['occupation'],
                $traveler['company'],
                $traveler['contact_number'],
                $traveler['philippines_address'],
                $traveler['last_departure_date'],
                $traveler['origin_country'],
                $traveler['airline'],
                $traveler['flight_number'],
                $traveler['arrival_date'],
                $traveler['remarks'],
                $traveler['findings'],
                $traveler['amount'],
            ];
            fputcsv($file, $export_data);
        }

        // return $for_export;

        foreach ($for_export as $export_data) {
            fputcsv($file, $export_data);
        }
        fclose($file);

        Storage::put($file_location, file_get_contents($temp_local_file_location));

        if (file_exists($temp_local_file_location)) {
            unlink($temp_local_file_location);
        }

        return [
            'current_page' => $request->page,
            'filename' => $filename,
        ];
    }

    public function downloadExport(Request $request) {
        $file_location = $request->file_location;
        return Storage::download($file_location);
    }
}
