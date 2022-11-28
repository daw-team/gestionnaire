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


class TeacherController extends Controller
{

public function getTeacherInfo(request $request) {
        return DB::table('ENSEIGNANT')
                        ->select('ENSEIGNANT.Nom_Ens','ENSEIGNANT.Prenom_Ens','ENSEIGNANT.UserName_Ens','ENSEIGNANT.Num_Mod','ENSEIGNANT.Photo_Ens')
                        ->where('ENSEIGNANT.Num_Ens', '=',$request->id )
                        ->get();
    }
public function getAllStudents(request $request){
    return DB::table('Etudiant')
                        ->select('Etudiant.Nom_Etud','Etudiant.Prenom_Etud','Etudiant.Num_Etud','Etudiant.Group_Etud','Etudiant.UserName_Etud','Etudiant.Photo_Etud')
                        ->get();
}

public function changeTeacherInfo(request $request) {
    $Ens = enseignant::where('Num_Ens', $request->id)->get();
        if($request->currentPassword === $Ens[0]['PassWord_Ens']){
        if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileExt = $file->extension();
        $newFile = 'teacher'.$request->id.'.'.$fileExt;
        $file->storeAs('public/profileImages', $newFile);
	enseignant::where('Num_Ens',$request->id)
		->update(['Photo_Ens' => $request->imgSrc]);
}
    
    	enseignant::where('Num_Ens',$request->id)
                ->update(['Nom_Ens' => $request->nom ,'Prenom_Ens' => $request->prenom,'UserName_Ens' => $request->username]);

    	if($request->newPassword != "" ){
            enseignant::where('Num_Ens',$request->id)
                ->update(['PassWord_Ens' => $request->newPassword]);
        }
        return response()->json([
                    'msg' => 'informations updated successfully',
                ]);
        }else  return response()->json([
            'msg' => 'wrong password',
        ]);
    }
    
    
    //untested functions

public function groupsList() {
  return DB::table('ETUDIANT')
                ->orderBy('Group_Etud')
                ->get();
                     
    } 

    public function absentDate(request $request) {
        enseignant::where('Num_Ens', '=',$request->id ) 
                     ->get();
                    return DB::table('ABSENCE')
                    ->select('ABSENCE.Date_Abs')
                    ->get();
                  
    }
    public function totalAbs(request $request) {
        enseignant::where('Num_Ens', '=',$request->id ) 
                     ->get();
                    return DB::table('ABSENCE')
                    ->get()
                    ->count();

    }

    public function creatAbs(request $request) {
       $num_etu= Etudiant::select('Num_Etud')
            ->get()
            ->value('Num_Etud');
        ABSENCE::insert(['Date_Abs' => $request->date ,'Hour_Abs' => $request->hour,'Num_Mod' => $request->num_module,'Num_Ens'=>$request->num_ens, 'Num_Etud'=>$num_etu]);
        return response()->json([
                'msg' => 'information inserted successfuly',
         ]); }


         public function deletAbs(request $request){
            ABSENCE::where('Num_Abs',$request->id)
                        ->delete();
            return response()->json([
             'msg' => 'information deleted successfuly',
               ]);         
        }  

        public function getNonJusAbsences(request $request) {
            ABSENCE::where('Num_Ens', '=',$request->id ) 
                ->where('Date_Abs', '=',$request->date ) 
                ->get();
            return DB::table('ABSENCE')
                         ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                         ->where('ABSENCE.Just_Abs', '=',NULL )
                         ->get();
                         
        }
    
    
    public function getPenAbsencesEns(request $request) {
        ABSENCE::where('Num_Ens', '=',$request->id ) 
                ->where('Date_Abs', '=',$request->date ) 
                ->get();
        return DB::table('ABSENCE') 
                ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                ->where('ABSENCE.Just_Abs', '!=',NULL )
                ->get();
                }
    
    public function getacceptedAbsences(request $request) {
        ABSENCE::where('Num_Ens', '=',$request->id ) 
                ->where('Date_Abs', '=',$request->date ) 
                ->get();
            return DB::table('ABSENCE')
                            ->where('ABSENCE.Type_Abs', '=','justifié' )
                            ->where('ABSENCE.Just_Abs', '!=',NULL )
                            ->get();
        } 
        
   public function exludedStudents(request $request){

        $result = absence::select(
                                'Num_Etud',
                                DB::raw('SUM(CASE WHEN Type_Abs = "nonJustifié" THEN 1 ELSE 0 END) AS unjustified'),
                                DB::raw('COUNT(Type_Abs) AS total')
                            )
                            ->where( 'Num_Ens', $request->id )
                            ->having( 'unjustified', '>=', 3 )
                            ->orHaving('total', '>=', 5)
                            ->groupby( 'Num_Etud' )
                            ->count();
        return $result;
    }
}

