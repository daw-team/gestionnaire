<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Etudiant;
use App\Models\enseignant;
use App\Models\Administrateur;


class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Http\JsonResponse;
     */
    public function index(Request $request)
    {
      //return Etudiant::orderBy('Num_Etud', 'ASC')->get();
      //check for an existing session:::
	if ($request->session()->has('sessUser')) {
    	return response()->json([
                        'msg' => 'session exist',
                        'session' => $request->session()->get('sessUser'),
                    ]);
}else {
return response()->json([
                        'msg' => 'no sessions',
                    ]);	
                    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Illuminate\Http\JsonResponse;
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse;
     */
    public function checkUser(Request $request)
    {	
        // we can use sql queries here instead of this: 
        $userEtud = Etudiant::where('UserName_Etud', $request->username)->get();
        $userEns = enseignant::where('UserName_Ens', $request->username)->get();
        $userAdm = Administrateur::where('UserName_Adm', $request->username)->get();


        // check if email exist in all the database
        if (count($userEtud) == 0 && count($userEns) == 0 && count($userAdm) == 0) {
            
            return response()->json([
                'msg' => 'please enter a valid email',
            ]);
        }

        //password check
        else {
            //student password check
            if (count($userEtud) != 0) {
                if($userEtud[0]['PassWord_Etud'] === strval($request->password)) {
                    // creating a session (session user)
                	$request->session()->put('sessUser', $userEtud[0]['Num_Etud']);
                	$sesUser = $request->session()->get('sessUser');
                    return response()->json([
                        'msg' => 'Etudiant',
                        'id' => $userEtud[0]['Num_Etud'],
			            'sessUser' => $sesUser,
                    ]);
                }
                else {
                    return response()->json([
                        'msg' => 'wrong password',
                    ]);
                }
            //teacher password check    
            }elseif (count($userEns)!= 0) {
                if($userEns[0]['PassWord_Ens'] === strval($request->password)) {
                    // creating a session (session user)
                    $request->session()->put('sessUser', $userEns[0]['Num_Ens']);
                    $sesUser = $request->session()->get('sessUser');
                    return response()->json([
                        'msg' => 'Enseignant',
                        'id' => $userEns[0]['Num_Ens'],
                        'sessUser' => $sesUser
                        
                    ]);
                }
                else {
                    return response()->json([
                        'msg' => 'wrong password',
                    ]);
                }
            //Admin password check
            }else{
                if($userAdm[0]['PassWord_Adm'] === strval($request->password)) {
                    // creating a session (session user)
                    $request->session()->put('sessUser', $userAdm[0]['Num_Adm']);
                    $sesUser = $request->session()->get('sessUser');
                    return response()->json([
                        'msg' => 'Administarteur',
                        'id' => $userAdm[0]['Num_Adm'],
                        'sessUser' => $sesUser

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
   
    
     public function logout(Request $request){
    
    $request->session()->flush();
    
 return  redirect('/login');

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
