<?php

namespace App\Http\Controllers;

use App\Bbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;

class BbsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Bbs::Join('users', 'users.id', '=', 'bbs.userid')->select('users.id', 'users.name', 'bbs.*')->orderBy('bbs.id', 'desc')->paginate(100);
        return view('home')->with('data', $data);
    }

    public function admincheck()
    {
        // $id = Auth::id();
        // $user = User::find($id);
        $admin_flag = Auth::user()->admin_flag;
        if ($admin_flag === 1) {
            //admin
            return true;
        } else {
            //Not
            return false;
        }
    }

    public function adminindex()
    {
        if (!$this->admincheck()) {
            return redirect()->route('home');
        }
        return view('admin');
    }

    public function admindelete()
    {
        if (!$this->admincheck()) {
            return redirect()->route('home');
        }
        DB::beginTransaction();
        try {
            Bbs::truncate();
            DB::commit();
        } catch (PDOException $e) {
            DB::rollBack();
        }
        return view('admin');
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
        $request->validate([
            'msg' => 'required|max:200',
        ]);
        DB::beginTransaction();
        try {
            $bbs = new \App\Bbs();
            $bbs->userid = Auth::id();
            $bbs->msg = $request->msg;

            $bbs->save();
            DB::commit();
        } catch (PDOException $e) {
            DB::rollBack();
        }
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bbs  $bbs
     * @return \Illuminate\Http\Response
     */
    public function show(Bbs $bbs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bbs  $bbs
     * @return \Illuminate\Http\Response
     */
    public function edit(Bbs $bbs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bbs  $bbs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bbs $bbs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bbs  $bbs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bbs $bbs)
    {
        //
    }
}
