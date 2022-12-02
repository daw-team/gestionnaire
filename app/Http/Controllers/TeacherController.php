<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// use Illuminate\Http\UploadedFile::extention;



use Illuminate\Http\Request;
use App\Models\absence;
use App\Models\Etudiant;
use App\Models\enseignant;
use App\Models\Administrateur;
use App\Models\Notification;
use App\Models\module;


class TeacherController extends Controller
{

public function getTeacherInfo(request $request) {
        return DB::table('ENSEIGNANT')
                        ->select('ENSEIGNANT.Nom_Ens','ENSEIGNANT.Prenom_Ens','ENSEIGNANT.UserName_Ens','ENSEIGNANT.Num_Mod','ENSEIGNANT.Photo_Ens')
                        ->where('ENSEIGNANT.Num_Ens', '=',$request->id )
                        ->get();
    }
public function getAllStudent(request $request){
    return DB::table('ETUDIANT')
                        ->select('ETUDIANT.Nom_Etud','ETUDIANT.Prenom_Etud','ETUDIANT.Num_Etud','ETUDIANT.Group_Etud','ETUDIANT.UserName_Etud','ETUDIANT.Photo_Etud')
                        ->get();
}


public function getAllStudents(request $request){
    return DB::table('ETUDIANT')
                        ->leftJoin('ABSENCE', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud'   )
                        ->select(
                            'ETUDIANT.Nom_Etud','ETUDIANT.Prenom_Etud', 'ETUDIANT.Num_Etud', 'ETUDIANT.Group_Etud',
                            DB::raw('SUM(CASE WHEN Type_Abs = "nonJustifié" AND Num_Ens = ' . $request->id . ' THEN 1 ELSE 0 END) AS unjustified'),
                            DB::raw('SUM(CASE WHEN Type_Abs = "Justifié" AND Num_Ens = ' . $request->id . ' THEN 1 ELSE 0 END) AS justified'),
                            )
                            ->groupby( 'ETUDIANT.Nom_Etud' , 'ETUDIANT.Prenom_Etud' , 'ETUDIANT.Num_Etud' , 'ETUDIANT.Group_Etud'   )
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

public function groupsList(request $request) {
  return Etudiant::select('ETUDIANT.Group_Etud')
                ->orderBy('Group_Etud')
                ->distinct()
                ->get();
    }

    public function absentDate(request $request) {
        return DB::table('ABSENCE')
                    ->select('ABSENCE.Date_Abs')
                    ->where('Num_Ens', '=',$request->id)
                    ->distinct()
                    ->get();
    }

    public function getTotalGroups(request $request) {
        return DB::table('ETUDIANT')
                    ->select('Group_Etud')
                    ->distinct()
                    ->get()
                    ->count();
    }


    public function totalAbs(request $request) {
        return DB::table('ABSENCE')
            ->where('Num_Ens', '=',$request->id)
            ->count();
    }

    public function createAbs(request $request) {

       foreach ($request->ids as $id) {
       $abrv = DB::table('MODULE')
            ->select('Abrv_Mod')
            ->where('MODULE.Num_Mod','=',$request->num_module)
            ->get()->value('Abrv_Mod');
        $queryState = absence::insert(['Date_Abs' => $request->date ,'Hour_Abs' => $request->hour,'Num_Mod' => $request->num_module,'Num_Ens'=>$request->num_ens, 'Num_Etud'=>$id]);
      if(!$queryState) {
    return response()->json([
                'msg' => 'operation failed (inserting absence)',
         ]);
         }
        $queryState = Notification::insert(['Des_Type' => 'Etudiant','Des_Id' => $id,'Text_Not' => 'unjustified absence in '.$abrv .' ']);
         if(!$queryState) {
    return response()->json([
                'msg' => 'operation failed (inserting notification)',
         ]);
}
$allAbsences = Absence::select('Num_Abs')
		->where('Num_Etud','=',$id)
		->where('Num_Ens','=',$request->num_ens)
            	->count();
            	if($allAbsences >= 5){
            		Notification::insert(['Des_Type' => 'Etudiant','Des_Id' => $id,'Text_Not' => 'you are exluded from '.$abrv .' ']);
            	}else {
            	
            	$unjustifiedAbs = Absence::select('Num_Abs')
		->where('Num_Etud','=',$id)
		->where('Num_Ens','=',$request->num_ens)
            	->where('Type_Abs','=','nonJustifié')
            	->count();
            	if($unjustifiedAbs >= 3){
            		Notification::insert(['Des_Type' => 'Etudiant','Des_Id' => $id,'Text_Not' => 'you are exluded from '.$abrv .' ']);
            	
            	}

}}
return response()->json([
                'msg' => 'information inserted successfuly'.$allAbsences,
         ]);
         
         }

public function acceptJust(request $request){
	$etud = Absence::select('Num_Etud')
            ->where('Num_Abs','=',$request->id)
            ->get()->value('Num_Etud');
         $nmr =   Absence::select('Num_Mod')
            ->where('Num_Abs','=',$request->id)
            ->get()->value('Num_Mod');
        $abrv = module::select('Abrv_Mod')
            ->where('Num_Mod','=',$nmr)
            ->get()->value('Abrv_Mod');

	$queryState = Absence::where('Num_Abs',$request->id)
                ->update(['Type_Abs' => "justifié"]);

        if(!$queryState) {
    return response()->json([
                'msg' => 'operation failed (accepting justification)',
         ]);
         }
        $queryState = Notification::insert(['Des_Type' => 'Etudiant','Des_Id' => $etud,'Text_Not' => ' '.$abrv.' jusifcation accepted']);
         if(!$queryState) {
    return response()->json([
                'msg' => 'operation failed (inserting notification)',
         ]);
}return response()->json([
                    'msg' => 'informations updated successfully',
                ]);
     }
     
     
public function rejectJust(request $request){
//get student id
	$etud = Absence::select('Num_Etud')
            ->where('Num_Abs','=',$request->id)
            ->get()->value('Num_Etud');
//get module id
         $nmr =   Absence::select('Num_Mod')
            ->where('Num_Abs','=',$request->id)
            ->get()->value('Num_Mod');
//get module abrv
        $abrv = module::select('Abrv_Mod')
            ->where('Num_Mod','=',$nmr)
            ->get()->value('Abrv_Mod');
            
            

//get justification path
$justPath = Absence::select('Just_Abs')
            ->where('Num_Abs','=',$request->id)
            ->get()->value('Just_Abs');
            
//delete justification file path from the DB
	$queryState = Absence::where('Num_Abs',$request->id)
                ->update(['Just_Abs' => NULL]);

//edit Type_Abs to nonJustifié
//	$queryState = Absence::where('Num_Abs',$request->id)
  //              ->update(['Type_Abs' => "nonJustifié"]);


$justPath = Str::substr($justPath, 46);

//delete justification file from public folder
$justPath = storage_path()."/app/public/justifications/$justPath";
 if(File::exists($justPath)){
          File::delete($justPath);
      }

//looking for errors...
        if(!$queryState) {
    return response()->json([
                'msg' => 'operation failed (rejecting justification)',
         ]);
         }
        $queryState = Notification::insert(['Des_Type' => 'Etudiant','Des_Id' => $etud,'Text_Not' => ' '.$abrv.' jusifcation rejected']);
         if(!$queryState) {
    return response()->json([
                'msg' => 'operation failed (inserting notification)',
         ]);

//if no errors return success msg
}return response()->json([
                    'msg' => 'information updated successfuly',
                ]);
     }
     
     

         public function deleteAbs(request $request){
            $queryState = absence::where('Num_Abs',$request->id)
                        ->delete();
            if(!$queryState) {
    return response()->json([
                'msg' => 'operation failed',
         ]);
}else return response()->json([
                'msg' => 'information deleted successfuly',
         ]);
        }


        public function getNonJusAbsences(request $request) {
             return DB::table('ABSENCE')
                        ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud')
            		    ->where('Num_Ens', '=',$request->id )
               		    ->where('Date_Abs', '=',$request->date )
                        ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                        ->where('ABSENCE.Just_Abs', '=',NULL )
                        ->get();
        }


    public function getPenAbsencesEns(request $request) {
        return DB::table('ABSENCE')
                ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud')
        	    ->where('Num_Ens', '=',$request->id )
                ->where('Date_Abs', '=',$request->date )
                ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                ->where('ABSENCE.Just_Abs', '!=',NULL )
                ->get();
                }

    public function getacceptedAbsences(request $request) {
        return DB::table('ABSENCE')
        ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud'   )
		->where('Num_Ens', '=',$request->id )
		->where('Date_Abs', '=',$request->date )
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


    public function studentsOfGroup(request $request) {
        return Etudiant::where('Group_Etud', '=',$request->id)
                    ->get();
    }

    public function getAllNonJusAbsences(request $request) {
        return DB::table('ABSENCE')
                    ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud')
                    ->where('Num_Ens', '=',$request->id )
                    ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                    ->where('ABSENCE.Just_Abs', '=',NULL )
                    ->get();
    }

    public function getAllPenAbsencesEns(request $request) {
        return DB::table('ABSENCE')
                ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud')
        	    ->where('Num_Ens', '=',$request->id )
                ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                ->where('ABSENCE.Just_Abs', '!=',NULL )
                ->get();
    }

    public function getAllacceptedAbsences(request $request) {
        return DB::table('ABSENCE')
        ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud')
		->where('Num_Ens', '=',$request->id )
		->where('ABSENCE.Type_Abs', '=','justifié' )
		->get();
    }

    public function getAbsByStudent(request $request){
       
            return ABSENCE::where('Num_Etud', '=',$request->id_Etud)
            ->where('Num_Ens', '=',$request->id_Ens)
             ->get();
        }
         public function getTeacherRecentAbs(request $request){
       
            return ABSENCE::where('Num_Ens', '=',$request->id)
             ->skip(0)
             ->take(10)
             ->orderby('Updated_At' , 'DESC')
             ->get();
        }
            
}

