<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;



use Illuminate\Http\Request;
use App\Models\absence;

class StudentController extends Controller
{
    public function getAbsences(request $request) {
        return DB::table('ABSENCE')
                        ->join('MODULE', 'MODULE.Num_Mod', '=', 'ABSENCE.Num_Mod')
                        ->select('MODULE.Abrv_mod','ABSENCE.Num_Etud', 'ABSENCE.Date_Abs', 'ABSENCE.Num_Abs')
                        ->where('ABSENCE.Num_Etud', '=',$request->id )
                        ->get();
    }

    public function storeImage(request $request) {
        $imagePath = $request->file('image')->store('images', 'public');
        return Absence::->where('Abs_Num', $request->num)
                            ->update(['Just_Abs' => "../../../storage/app/public/$imagePath"]);
        // where('Abs_Num', $request->num)->get();
        // return $imagePath;
    }
}
