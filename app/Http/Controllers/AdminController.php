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


class AdminController extends Controller
{
public function getAdminInfo(request $request) {
        return DB::table('ADMINISTRATEUR')
                        ->select('ADMINISTRATEUR.Nom_Adm','ADMINISTRATEUR.Prenom_Adm')
                        ->where('ADMINISTRATEUR.Num_Adm', '=',$request->id )
                        ->get();
    }
}

