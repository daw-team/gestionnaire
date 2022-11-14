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



}