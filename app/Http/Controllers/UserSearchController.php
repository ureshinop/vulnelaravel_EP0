<?php

namespace App\Http\Controllers;

use App\UserSearch;
use Illuminate\Http\Request;
use DB;
use PDO;
use App\User;

class UserSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('search');
    }

    public function post(Request $request)
    {
        $request->validate([
            'userid' => 'required',
        ]);
        $message = "";
        $userid = $_GET['userid'];

        $slevel = (int)env('S_LEVEL', 1);
        $table = "users";
        if ($slevel === 0) {
            //LV0
            $pdo = DB::connection()->getPdo();
            $sql = "SELECT * FROM $table where userid LIKE '%$userid%' and userid != 'admin'";
            $stmt = $pdo->query($sql);
            $users = collect([]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $k => $row) {
                $users->push($row);
            }
            return view('search')->with(['users' => $users,'userid' => $userid]);
        } elseif ($slevel === 1) {
            //LV1
            $users = User::whereRaw("userid LIKE '%$userid%'")->get();
            return view('search')->with(['users' => $users,'userid' => $userid]);
        } elseif ($slevel === 2) {
            //LV2 FIX
            $userid = $request->input('userid');
            $userid = $this->escape_like($userid);
            $users = User::where('userid', 'LIKE', "%$userid%")->whereNotIn("userid", ['admin'])->get();
            // dd($users->toSql(), $users->getBindings(), $users->get());
            
            return view('search')->with(['users' => $users,'userid' => $userid]);
        } else {
            abort(404);
        }

        // return view('auth.login');
    }
    public function escape_like(string $value, string $char = '\\'): string
    {
        return str_replace(
        [$char, '%', '_'],
        [$char.$char, $char.'%', $char.'_'],
        $value
    );
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function show(UserSearch $userSearch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSearch $userSearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSearch $userSearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSearch $userSearch)
    {
        //
    }
}
