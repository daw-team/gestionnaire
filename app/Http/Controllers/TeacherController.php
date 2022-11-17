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
                        ->select('ENSEIGNANT.Nom_Ens','ENSEIGNANT.Prenom_Ens')
                        ->where('ENSEIGNANT.Num_Ens', '=',$request->id )
                        ->get();
    }
public function getAllStudents(request $request){
    return DB::table('Etudiant')
                        ->select('Etudiant.Nom_Etud','Etudiant.Prenom_Etud','Etudiant.Num_Etud','Etudiant.Group_Etud','Etudiant.UserName_Etud','Etudiant.Photo_Etud')
                        ->get();
}


}
