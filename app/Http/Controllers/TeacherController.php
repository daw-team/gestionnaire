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

}
