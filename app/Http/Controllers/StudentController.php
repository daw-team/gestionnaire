<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
// use Illuminate\Http\UploadedFile::extention;



use Illuminate\Http\Request;
use App\Models\absence;
use App\Models\Etudiant;
use App\Models\enseignant;
use App\Models\Administrateur;
use App\Models\module;


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


public function getStudentInfo(request $request) {
        return DB::table('ETUDIANT')
                        ->select('ETUDIANT.Nom_Etud','ETUDIANT.Prenom_Etud','ETUDIANT.Group_Etud','ETUDIANT.UserName_Etud','ETUDIANT.Photo_Etud')
                        ->where('ETUDIANT.Num_Etud', '=',$request->id )
                        ->get();
    }


    public function getTotalAbsNbr(request $request) {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->count();


    }

    public function storeImage(request $request) {
        $file = $request->file('image');
        $fileExt = $file->extension();
        $newFile = time() .'.'.$fileExt;
        $filePath = $file->storeAs('public/justifications', $newFile);
        return Absence::where('Num_Abs', $request->num)
                            ->update(['Just_Abs' => "../../../storage/app/public/$filePath"]);
}


public function getJustifiedAbsNbr(request $request) {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','justifié' )
    			->count();

    }




    public function getNonJustifiedAbsNbr(request $request ) {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','nonJustifié' )
    			->where('ABSENCE.Just_Abs', '=',NULL )
    			->count();

    }
    public function getTotalPendJus(request $request) {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','nonJustifié' )
    			->where('ABSENCE.Just_Abs', '=!',NULL )
    			->count();

    }

    public function changeStudentInfo(request $request) {
        $Etud = Etudiant::where('Num_Etud', $request->id)->get();
        if($request->currentPassword == $Etud[0]['PassWord_Etud']){
         $file = $request->file('image');
        $fileExt = $file->extension();
        $newFile = 'student'.$request->id.'.'.$fileExt;
        $file->storeAs('public/profileImages', $newFile);
    	Etudiant::where('Num_Etud',$request->id)
                ->update(['Nom_Etud' => $request->nom ,'Prenom_Etud' => $request->prenom,'UserName_Etud' => $request->username,'Photo_Etud' => $request->imgSrc]);

    	if($request->newPassword != "" ){
            Etudiant::where('Num_Etud',$request->id)
                ->update(['PassWord_Etud' => $request->newPassword]);
        }
        return response()->json([
                    'msg' => 'informations updated successfully',
                ]);
        }else  return response()->json([
            'msg' => 'wrong password',
        ]);
    }


	public function getAllModules() {
	return DB::table('MODULE')->get();
    }

    public function ssss(request $request) {
        return $request;
    }
}
