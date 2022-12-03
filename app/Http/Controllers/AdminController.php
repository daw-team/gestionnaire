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
use App\Models\Notification;


class AdminController extends Controller
{
public function getAdminInfo(request $request) {
        return DB::table('ADMINISTRATEUR')
                        ->select('ADMINISTRATEUR.Nom_Adm','ADMINISTRATEUR.Prenom_Adm','ADMINISTRATEUR.UserName_Adm','ADMINISTRATEUR.Photo_Adm')
                        ->where('ADMINISTRATEUR.Num_Adm', '=',$request->id )
                        ->get();
    }

public function changeAdminInfo(request $request) {
    $Adm = Administrateur::where('Num_Adm', $request->id)->get();
        if($request->currentPassword === $Adm[0]['PassWord_Adm']){
        if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileExt = $file->extension();
        $newFile = 'admin'.$request->id.'.'.$fileExt;
        $file->storeAs('public/profileImages', $newFile);
	Administrateur::where('Num_Adm',$request->id)
		->update(['Photo_Adm' => $request->imgSrc]);
}

    Administrateur::where('Num_Adm',$request->id)
                ->update(['Nom_Adm' => $request->nom ,'Prenom_Adm' => $request->prenom,'UserName_Adm' => $request->username]);

    if($request->newPassword != "" ){
     Administrateur::where('Num_Adm',$request->id)
                ->update(['PassWord_Adm' => $request->newPassword]);
     }
     return response()->json([
                    'msg' => 'informations updated successfully',
                ]);
     }else  return response()->json([
            'msg' => 'wrong password',
      ]);
   }
public function TotalStudentsNbr(request $request) {
        return DB::table('ETUDIANT')
               ->count();
}
public function TotalTeachersNbr(request $request) {
        return DB::table('ENSEIGNANT')
                ->count();
}
public function TotalModulesNbr(request $request) {
        return DB::table('MODULE')
                ->count();
 }

public function TotalAbsencesNbr(request $request) {
        return DB::table('ABSENCE')
                ->count();
    }

public function studentsList(request $request) {
        return DB::table('ETUDIANT')
                 ->get();
}
public function teachersList(request $request) {
        return DB::table('ENSEIGNANT')
                 ->get();
}
public function modulesList(request $request) {
        return DB::table('MODULE')
                 ->get();
}
public function absencesList(request $request) {
        return DB::table('ABSENCE')
        ->orderby('ABSENCE.Date_Abs' , 'DESC')

                 ->get();
}

public function unjustifiedAbsences(request $request){
        return DB::table('ABSENCE')
		    ->join('MODULE', 'ABSENCE.Num_Mod', '=', 'MODULE.Num_Mod')
		    ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud')
                    ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                    ->where('ABSENCE.Just_Abs', '=',NULL )
                    ->orderby('ABSENCE.Date_Abs' , 'DESC')

                    ->get();
}

public function pendingAbsences(request $request){
        return DB::table('ABSENCE')
       		    ->join('MODULE', 'ABSENCE.Num_Mod', '=', 'MODULE.Num_Mod')
		    ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud')
                    ->where('ABSENCE.Type_Abs', '=','nonJustifié' )
                    ->where('ABSENCE.Just_Abs', '!=',NULL )
                    ->orderby('ABSENCE.Date_Abs' , 'DESC')

                    ->get();
}
public function justifiedAbsences(request $request){
        return DB::table('ABSENCE')
        	    ->join('MODULE', 'ABSENCE.Num_Mod', '=', 'MODULE.Num_Mod')
		    ->join('ETUDIANT', 'ABSENCE.Num_Etud', '=', 'ETUDIANT.Num_Etud')
                    ->where('ABSENCE.Type_Abs', '=','Justifié' )
                    ->orderby('ABSENCE.Date_Abs' , 'DESC')

                    ->get();
}
public function deleteStudent(request $request){
    Etudiant::where('Num_Etud',$request->id)
              ->delete();
    return response()->json([
           'msg' => 'information deleted successfuly',
       ]);

 }
public function deleteTeacher(request $request){
    Enseignant::where('Num_Ens',$request->id)
                ->delete();
    return response()->json([
     'msg' => 'information deleted successfuly',
       ]);
}

public function deleteModule(request $request){

        Module::where('Num_Mod',$request->id)
                 ->delete();
        return response()->json([
           'msg' => 'information deleted successfuly',
         ]) ;

 }

public function studentInformation(request $request) {
    return DB::table('ETUDIANT')
           ->where('ETUDIANT.Num_Etud','=',$request->id)
           ->get();
}

public function teacherInformation(request $request) {
    return DB::table('ENSEIGNANT')
            ->where('ENSEIGNANT.Num_Ens','=',$request->id)
            ->get();
 }

public function moduleInformation(request $request) {
     return DB::table('MODULE')
                ->where('MODULE.Num_Mod', '=',$request->id)
                ->get();
 }

public function updateTeacherInfo(request $request){
     $num_mod = DB::table('MODULE')
               ->select('Num_Mod')
               ->where('MODULE.Abrv_Mod','=',$request->module_abriviation)
                ->get()->value('Num_Mod');
    if($request->password != "" ){
            Enseignant::where('Num_Ens',$request->id)
                ->update(['PassWord_Ens' => $request->password]);
        }
    Enseignant::where('Num_Ens',$request->id)
            ->update(['Nom_Ens' => $request->firstname ,'Prenom_Ens' => $request->lastname,'UserName_Ens' => $request->email,'Num_Mod'=>$num_mod]);
    return response()->json([
            'msg' => 'information updated successfuly',
        ]);
     }

public function updateStudentInfo(request $request){
               if($request->password != "" ){
            Etudiant::where('Num_Etud',$request->id)
                ->update(['PassWord_Etud' => $request->password]);
        }
   Etudiant::where('Num_Etud',$request->id)
          ->update(['Nom_Etud' => $request->fname ,'Prenom_Etud' => $request->lname,'UserName_Etud' => $request->email,'Group_Etud'=>$request->groupe]);
    return response()->json([
         'msg' => 'information updated successfuly',
                   ]);
}

public function updateModuleInfo(request $request){
        $Coeff_Mod=intval($request->coefficient);
        $Credit_Mod=intval($request->credit);
        return Module::where('Num_Mod',$request->id)
         ->update(['Nom_Mod' => $request->name ,'Abrv_Mod' => $request->abriviation,'Coeff_Mod'=>$Coeff_Mod,'Credit_Mod'=>$Credit_Mod]);
//     return response()->json([
//         'msg' => 'information updated successfuly',
//           ]);
 }

public function CreateTeacher(request $request){
    $num_mod = DB::table('MODULE')
            ->select('Num_Mod')
            ->where('MODULE.Abrv_Mod','=',$request->module_abriviation)
            ->get()->value('Num_Mod');
     Enseignant::insert(['Nom_Ens' => $request->lastname ,'Prenom_Ens' => $request->firstname,'UserName_Ens' => $request->email,'PassWord_Ens'=>$request->password,'Num_Mod'=> $num_mod]);
     return response()->json([
                'msg' => 'information inserted successfuly',
         ]);
}


public function CreateStudent(Request $request) {
    Etudiant::insert(['Nom_Etud'=>$request->lname,'Prenom_Etud' => $request->fname,'UserName_Etud' => $request->email,'PassWord_Etud'=>$request->password,'Group_Etud'=>$request->groupe]);
     return response()->json([
    'msg' => 'information inserted successfuly',
        ]);
}

public function CreateModule(Request $request) {
    Module::insert(['Nom_Mod' => $request->name ,'Abrv_Mod' => $request->abriviation,'Coeff_Mod' => $request->coefficient,'Credit_Mod'=>$request->credit]);
    return response()->json([
     'msg' => 'information inserted successfuly',
        ]);
}
public function getAbsenceInfo(request $request) {
    return DB::table('ABSENCE')
           ->where('ABSENCE.Num_Abs','=',$request->id)
           ->get();
}

}

