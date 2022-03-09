<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Information;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\Subscribe;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

      /**
     * e.
     Personelleri listelemek için kıllılan sayfa
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
       return view("live.user.list");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(UserRequest $request)
    {

       $information = Information::create($request->only("name","surname","birthday"));
$password = $this->generatePassword(6,3);
      $user= User::create(array_merge($request->only("user_name","email"),['password' => bcrypt($password),"information_id"=> $information->id] ));


      Mail::to("huseyinkertik0@gmail.com")->send(new Subscribe($information));


        dd($user,$password);
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


    function generatePassword($length=6,$level=2){

        list($usec, $sec) = explode(' ', microtime());
        srand((float) $sec + ((float) $usec * 100000));

        $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
        $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

        $password  = "";
        $counter   = 0;

        while ($counter < $length) {
          $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);

          // All character must be different
          if (!strstr($password, $actChar)) {
             $password .= $actChar;
             $counter++;
          }
        }

        return $password;
     }
}
