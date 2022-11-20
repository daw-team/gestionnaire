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
}

