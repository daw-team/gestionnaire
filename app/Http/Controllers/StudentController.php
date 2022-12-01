<?php

namespace App\Http\Controllers;


// use Illuminate\Http\UploadedFile::extention;
use App\Models\absence;
use App\Models\Administrateur;
use App\Models\enseignant;
use App\Models\Etudiant;
use App\Models\module;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
//session checker
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

//Student checker
public function studentCheck(request $request){



// if the user is not logged in as a student : return 0
// if the user is logged in and the sessUser matches the request id: return 1
// if the user is logged in as a different student (different than request id) : return 2


    $Etud = Etudiant::where('Num_Etud', $request->id)->get();
    //check if logged in as a student
    if (count($Etud) != 0){
   		 //check if the method is allowed (request id is same as the id of the student who is logged in)
   		 // ( a user can't send or receive data of a student unless he is logged in as the same student account (checked using sessUser)
   		 if ($request->id == $request->session()->get('sessUser')) {
     		   return 1; // student is logged in
    }else { 
    		return 2; //student is logged in but has not access to another student data
    	}
}return 0;  //student is not logged in
}






//public function createAbs(request $request) {
//    	 absence::create([
//    'Num_Abs' => 333,'Num_Etud' => 202031030632 ,'Num_Ens' => 202031030666, 'Num_Mod' => 5,'Date_Abs' => "2022-11-13",'Hour_Abs' => "8:30 11:00",
//]);
//$data = absence::where('ABSENCE.Num_Abs', '=',333 )
//    			->get();
//    			print($data);

//    }




//all absences number
public function getTotalAbsNbr(request $request) {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->count();


    }
    //all absences
    public function getAllAbsences(request $request) {
        return DB::table('ABSENCE')
                        ->join('MODULE', 'MODULE.Num_Mod', '=', 'ABSENCE.Num_Mod')
                        ->select('MODULE.Abrv_Mod','ABSENCE.Num_Etud', 'ABSENCE.Date_Abs','ABSENCE.Hour_Abs', 'ABSENCE.Num_Abs' , 'ABSENCE.Just_Abs')
                        ->where('ABSENCE.Num_Etud', '=',$request->id )
                        ->orderby('ABSENCE.Date_Abs' , 'DESC')
                        ->get();
    }










//non justified absences
    public function getNonJusAbsences(request $request) {
        return DB::table('ABSENCE')
                        ->join('MODULE', 'MODULE.Num_Mod', '=', 'ABSENCE.Num_Mod')
                        ->select('MODULE.Abrv_Mod','ABSENCE.Num_Etud', 'ABSENCE.Date_Abs','ABSENCE.Hour_Abs', 'ABSENCE.Num_Abs')
                        ->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                        ->where('ABSENCE.Just_Abs', '=',NULL )
                        ->orderby('ABSENCE.Date_Abs' , 'DESC')
                        ->get();
    }


//non justified absences number
public function getNonJustifiedAbsNbr(request $request ) {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','nonJustifié' )
    			->where('ABSENCE.Just_Abs', '!=',NULL )
    			->count();

    }












//justified absences
	public function getJusAbsences(request $request) {
        return DB::table('ABSENCE')
                        ->join('MODULE', 'MODULE.Num_Mod', '=', 'ABSENCE.Num_Mod')
                        ->select('MODULE.Abrv_Mod','ABSENCE.Num_Etud', 'ABSENCE.Date_Abs','ABSENCE.Hour_Abs', 'ABSENCE.Num_Abs','ABSENCE.Just_Abs')
                        ->where('ABSENCE.Num_Etud', '=',$request->id )
                        ->where('ABSENCE.Type_Abs', '=','justifié' )
                        ->orderby('ABSENCE.Date_Abs' , 'DESC')
                        ->get();
    }

   //justified absences number
public function getJustifiedAbsNbr(request $request) {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','justifié' )
    			->count();

    }












//pending absences
    public function getPenAbsences(request $request) {
        return DB::table('ABSENCE')
                        ->join('MODULE', 'MODULE.Num_Mod', '=', 'ABSENCE.Num_Mod')
                        ->select('MODULE.Abrv_Mod','ABSENCE.Num_Etud', 'ABSENCE.Date_Abs','ABSENCE.Hour_Abs', 'ABSENCE.Num_Abs','ABSENCE.Just_Abs')
                        ->where('ABSENCE.Num_Etud', '=',$request->id )
                        ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                        ->where('ABSENCE.Just_Abs', '!=',NULL )
                        ->orderby('ABSENCE.Date_Abs' , 'DESC')


                        ->get();
    }

//pending absences number
    public function getTotalPendJusNbr(request $request) {
    	return DB::table('ABSENCE')
    			->where('ABSENCE.Num_Etud', '=',$request->id )
    			->where('ABSENCE.Type_Abs', '=','nonJustifié' )
    			->where('ABSENCE.Just_Abs', '!=',NULL )
    			->count();

    }









public function getStudentInfo(request $request) {
        return DB::table('ETUDIANT')
                        ->select('ETUDIANT.Nom_Etud','ETUDIANT.Prenom_Etud','ETUDIANT.Group_Etud','ETUDIANT.UserName_Etud','ETUDIANT.Photo_Etud')
                        ->where('ETUDIANT.Num_Etud', '=',$request->id )
                        ->get();
    }







    public function storeImage(request $request) {
    	$filename = $request->num;
        $file = $request->file('image');
        $fileExt = $file->extension();
        $newFile = $filename.'.'.$fileExt;
        $filePath = $file->storeAs('public/justifications', $newFile);
        $resp =  Absence::where('Num_Abs', $request->num)
                            ->update(['Just_Abs' => "../../../../storage/app/$filePath"]);
	if($resp != 0){
		$ens = Absence::select('Num_Ens')
            ->where('Num_Abs', $request->num)
            ->get()->value('Num_Ens');
		$queryState = Notification::insert(['Des_Type' => 'Enseignant','Des_Id' => $ens,'Text_Not' => 'unchecked justification']);
         if(!$queryState) {
    return response()->json([
                'msg' => 'operation failed (inserting notification)',
         ]);
}else return 1;  
	}else return response()->json([
                'msg' => 'operation failed (uploading justification)',
         ]);
}













    public function changeStudentInfo(request $request) {
        if($this->studentCheck($request) == 1){
    $Etud = Etudiant::where('Num_Etud', $request->id)->get();
        if($request->currentPassword === $Etud[0]['PassWord_Etud']){
        if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileExt = $file->extension();
        $newFile = 'student'.$request->id.'.'.$fileExt;
        $file->storeAs('public/profileImages', $newFile);
	Etudiant::where('Num_Etud',$request->id)
		->update(['Photo_Etud' => $request->imgSrc]);
}

    	Etudiant::where('Num_Etud',$request->id)
                ->update(['Nom_Etud' => $request->nom ,'Prenom_Etud' => $request->prenom,'UserName_Etud' => $request->username]);

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
        }else{
		if($this->studentCheck($request) == 2){
		return response()->json([
                            'msg' => 'access denied',
                        ]);
		}else if($this->studentCheck($request) == 0){
		return response()->json([
                            'msg' => 'login as a student first',
                        ]);
		}
    }
    }











	public function getAllModules() {
	return DB::table('MODULE')
				 ->join('ENSEIGNANT', 'ENSEIGNANT.Num_Mod', '=', 'MODULE.Num_Mod')
				 ->select('MODULE.Abrv_mod', 'MODULE.Num_Mod', 'MODULE.Nom_Mod','MODULE.Coeff_Mod' ,'MODULE.Credit_Mod','ENSEIGNANT.Num_Ens','ENSEIGNANT.Nom_Ens','ENSEIGNANT.Prenom_Ens')
				 ->get();
				 }




    public function sendTeacherEmail(request $request) {
        return DB::table('MODULE')
				 ->join('ENSEIGNANT', 'ENSEIGNANT.Num_Mod', '=', 'MODULE.Num_Mod')
				 ->select('MODULE.Abrv_mod','ENSEIGNANT.Nom_Ens','ENSEIGNANT.Prenom_Ens','ENSEIGNANT.UserName_Ens')
				 ->get();
				 }


    
    public function getModulesAbsences(request $request){
            return DB::table('ABSENCE')
                        ->join('MODULE', 'ABSENCE.Num_Mod', '=', 'MODULE.Num_Mod'   )
                         ->select(
                         'MODULE.Abrv_Mod', 
                         DB::raw('COUNT(Type_Abs) AS total'),
                          DB::raw('SUM(CASE WHEN Type_Abs = "nonJustifié" THEN 1 ELSE 0 END) AS unjustified'),
                       DB::raw('SUM(CASE WHEN Type_Abs = "Justifié" THEN 1 ELSE 0 END) AS justified'),
                                            )
                        ->where('ABSENCE.Num_Etud', '=' , $request->id)
                       ->groupby( 'Module.Abrv_Mod' )
                         ->get();
                }

        
            // get the excluded modules
    public function getExcludedModules(request $request){
        return DB::table('ABSENCE')
        ->join('MODULE', 'ABSENCE.Num_Mod', '=', 'MODULE.Num_Mod'   )
         ->select(
         'MODULE.Abrv_Mod'
        //  DB::raw('SUM(CASE WHEN Type_Abs = "nonJustifié" THEN 1 ELSE 0 END) AS unjustified'),
        //  DB::raw('COUNT(Type_Abs) AS total')
        ) 
        ->where('ABSENCE.Num_Etud', '=' , $request->id)
        ->having( DB::raw('SUM(CASE WHEN Type_Abs = "nonJustifié" THEN 1 ELSE 0 END)'), '>=', 3 )
        ->orHaving(DB::raw('COUNT(Type_Abs)'), '>=', 5)
       ->groupby( 'Module.Abrv_Mod' )
         ->get();
        
    
        }

        public function getNbrExcludedMod(request $request){

            $result = absence::select(
                                    'Num_Mod',
                                    DB::raw('SUM(CASE WHEN Type_Abs = "nonJustifié" THEN 1 ELSE 0 END) AS unjustified'),
                                    DB::raw('COUNT(Type_Abs) AS total')
                                )
                                ->where( 'Num_Etud', $request->id )
                                ->having( 'unjustified', '>=', 3 )
                                ->orHaving('total', '>=', 5)
                                ->groupby( 'Num_Mod' )
                                ->count();
            return $result;
        
        }
    
                

}

 
