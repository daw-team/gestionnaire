<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
// use Illuminate\Http\UploadedFile::extention;



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
                        ->where('ABSENCE.Just_Abs', '=',NULL )
                        ->get();
    }

    public function storeImage(request $request) {
        $file = $request->file('image');
        $fileExt = $file->extension();
        $newFile = time() .'.'.$fileExt;
        $filePath = $file->storeAs('public/justifications', $newFile);
        return Absence::where('Num_Abs', 1000)
                            ->update(['Just_Abs' => "../../../storage/app/public/$filePath"]);
    }
}
