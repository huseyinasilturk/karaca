<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Information;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\Subscribe;
use App\Models\Company;
use App\Models\Wage;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * e.
     * Personelleri listelemek için kıllılan sayfa
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Personeller"], ['name' => "Liste"]
        ];

        $roles = Role::all();
        $company = Company::all();

        return view("live.user.list", compact("roles", "company", "breadcrumbs"));
    }
    public function detail($id = false)
    {
        if ($id) {
            $user = User::join("information", "information.id", "=", "users.information_id")->join("model_has_roles as mhr", "mhr.model_id", "=", "users.id")
                ->join("roles as r", "r.id", "=", "mhr.role_id")->where("users.id", "=", $id)->join("wages", "wages.user_id", "users.id")->where("wages.status", "=", "1")
                ->select([DB::raw("CONCAT(information.name,' ',information.surname) as name_surname"), "users.*", "information.*", "users.id as user_id", "r.title as role_title", "r.name as role_name", "wages.wage_price as wage_price"])->get()->first();

            return view("live.user.detail", compact("user"));
        } else {
            return view("live.user.list");
        }
    }

    public function userList()
    {
        $user = User::join("information", "information.id", "=", "users.information_id")->join("model_has_roles as mhr", "mhr.model_id", "=", "users.id")
            ->join("roles as r", "r.id", "=", "mhr.role_id")
            ->join("wages", "wages.user_id", "users.id")->where("wages.status", "=", "1")
            ->select([DB::raw("CONCAT(information.name,' ',information.surname) as name_surname"), "wages.wage_price as wage", "users.*", "information.*", "users.id as user_id", "r.title as role_title", "r.name as role_name"])->get();


        return  response()->json(["data" => $user], 202);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = DB::table("users as u")->join("information as i", "i.id", "=", "u.information_id")->get();
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


        $information = Information::create($request->only("name", "surname", "birthday"));

        $password = $this->generatePassword(6, 2);

        $user = User::create(array_merge($request->only("user_name", "email", "company_id"), ['password' => bcrypt($password), "information_id" => $information->id]));
        $wage = Wage::create(['wage_price' => $request->wage, 'wage_date' => Carbon::now(), 'status' => 1, "user_id" => $user->id]);

        $userName = $request->name . " " . $request->surname;

        $user_information = array(["name" => $userName, "user_name" => $request->user_name, "password" => $password]);

        Mail::to($request->only("email"))->send(new Subscribe($user_information));


        $assingRole = $user->assignRole($request->user_role);

        $roles = Role::all();

        $company = Company::all();
        return redirect()->back()->with(['company' => $company, 'roles' => $roles]);
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
    public function update(UserRequest $request, $id)
    {


        $information = Information::create($request->only("name", "surname", "birthday"));

        $user = User::find($id);

        $user->update($request->only("user_name", "email", "company_id"));

        $wage = Wage::where("user_id", "=", $id)->where("wage_price", "=", $request->wage)->where("status", "=", 1);

        $test = $wage->get()->first();

        if ($test->wage_price == $request->wage) {
            return response()->json(["status" => $wage->get(), "test" => 1]);
        }

        return response()->json(["status" => $test]);

        $information = Information::find($user->information_id)->update($request->only("name", "surname", "birthday"));

        Wage::where("user_id", "=", $user->id)->update(["status" => 0]);

        $assingRole = $user->syncRoles($request->user_role);

        return response()->json(["status" => 202]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            User::find($id)->delete();
            return response()->json(["message" => "Personel Silindi."], 202);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Personel Silinemedi."], 404);
        }
    }


    function generatePassword($length = 6, $level = 2)
    {

        list($usec, $sec) = explode(' ', microtime());
        srand((float) $sec + ((float) $usec * 100000));

        $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
        $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

        $password  = "";
        $counter   = 0;

        while ($counter < $length) {
            $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level]) - 1), 1);

            // All character must be different
            if (!strstr($password, $actChar)) {
                $password .= $actChar;
                $counter++;
            }
        }

        return $password;
    }
}
