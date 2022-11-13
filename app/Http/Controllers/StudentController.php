<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;



use Illuminate\Http\Request;
use App\Models\absence;

class StudentController extends Controller
{
    public function index(Request $request)
    {

        if ($request->session()->has('sessUser')) {
            return response()->json([
                            'msg' => 'session exist',
                            'session' => $request->session()->get('sessUser'),
                        ]);
        }
        else {
        return response()->json([
                            'msg' => 'no sessions',
                        ]);
        }
    }


    public function getAbsences(request $request) {
        return DB::table('ABSENCE')
                        ->join('MODULE', 'MODULE.Num_Mod', '=', 'ABSENCE.Num_Mod')
                        ->select('MODULE.Abrv_mod','ABSENCE.Num_Etud', 'ABSENCE.Date_Abs', 'ABSENCE.Num_Abs')
                        ->where('ABSENCE.Num_Etud', '=',$request->id )
                        ->get();
    }
    public function getTotalAbsNbr() {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->count();
    			
    }
    
    
    
    
public function getJustifiedAbsNbr() {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','justifié' )
    			->count();
    			
    }
    
    
    
    
    public function getNonJustifiedAbsNbr() {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','nonJustifié' )
    			->where('ABSENCE.Just_Abs', '=',NULL )
    			->count();
    			
    }
    public function getTotalPendJus() {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','nonJustifié' )
    			->where('ABSENCE.Just_Abs', '=!',NULL )
    			->count();
    			
    }
    
    
