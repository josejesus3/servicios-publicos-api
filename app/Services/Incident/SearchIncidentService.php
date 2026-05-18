<?php
namespace App\Services\Incident;

use App\Http\Requests\SearchIncidentRequest;
use App\Models\Incident;
use Illuminate\Support\Facades\DB;

class SearchIncidentService {

    public function searchService( SearchIncidentRequest $request ) {
        $user = auth()->user();
        $query = Incident::query()->with(['media']);

        if ( in_array( $user->role_id, [ 1, 4 ] ) ) {

        } elseif ( $user->role_id == 2 ) {
            $query->where( 'user_id', $user->id );
        } elseif ( $user->role_id == 3 ) {
            $query->where( 'area_id', $user->id );
        }

         $filters = ['title', 'description', 'direction'];

         foreach($filters as $filter){
            $query->when($request->filled($filter),function ($q)use ($request,$filter) {
                $q->where($filter,'like',"%{$request->$filter}%");
            });
         }
         return $query
         ->latest()
         ->paginate(5)
         ->withQueryString();

    }
}