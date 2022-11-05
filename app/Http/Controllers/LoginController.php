<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\enseignant;
use App\Models\Administrateur;


class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Etudiant::orderBy('Num_Etud', 'ASC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkUser(Request $request)
    {
        $userEtud = Etudiant::where('UserName_Etud', $request->username)->get();
        $userEns = enseignant::where('UserName_Etud', $request->username)->get();
        $userAdm = Administrateur::where('UserName_Etud', $request->username)->get();
        if (count($userEtud) == 0 && count($userEns) == 0 && count($userAdm) == 0) {
            
            return response()->json([
                'msg' => 'please enter a valid email',
            ]);
        }
        else {
            if (count($userEtud) != 0) {
                if($userEtud[0]['PassWord_Etud'] === strval($request->password)) {
                    return response()->json([
                        'msg' => 'welcome',
                    ]);
                }
                else {
                    return response()->json([
                        'msg' => 'wrong password',
                    ]);
                }
            }elseif (count($userEns)!= 0) {
                if($userEns[0]['PassWord_Etud'] === strval($request->password)) {
                    return response()->json([
                        'msg' => 'welcome',
                    ]);
                }
                else {
                    return response()->json([
                        'msg' => 'wrong password',
                    ]);
                }
            }else{
                if($userAdm[0]['PassWord_Etud'] === strval($request->password)) {
                    return response()->json([
                        'msg' => 'welcome',
                    ]);
                }
                else {
                    return response()->json([
                        'msg' => 'wrong password',
                    ]);
                }
            }
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
