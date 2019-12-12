<?php

namespace App\Http\Controllers;

use App\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use PDO;
use Log;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'password' => 'required',
        ]);
        if (!env('LOGIN_FIX')) {
            $message = "";
            $userid = $_POST['userid'];
            $password = $_POST['password'];
            $login_level = (int)env('LOGIN_LEVEL', 1);
            $table = "users";
            if ($login_level === 0) {
                //LV0
                $logind = false;
                $pdo = DB::connection()->getPdo();

                $sql = "SELECT * FROM $table where userid = '$userid' and password = '$password'";
                $stmt = $pdo->query($sql);
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $raw = $row;
                }
                if (!empty($raw)) {
                    $id = $row['id'];
                    Auth::loginUsingId($id);
                    return redirect()->intended('/');
                } else {
                    return redirect()->route('login')
                ->withErrors(array('userid' => 'ログインに失敗しました。'))
                ->with(['message' => $message, "status" => true]);
                }
            } elseif ($login_level === 1) {
                //LV1
                $logind = false;
                $row = Login::whereRaw("userid = '$userid' and password = '$password'")
            ->first();
        
                if (!empty($row)) {
                    $id = $row->id;
                    Auth::loginUsingId($id);
                    return redirect()->intended('/');
                } else {
                    return redirect()->route('login')
                ->withErrors(array('userid' => 'ログインに失敗しました。'))
                ->with(['message' => $message, "status" => true]);
                }
            } elseif ($login_level === 2) {
                //LV2
                abort(404);
            } else {
                abort(404);
            }

            return view('auth.login');
        } else {
            //修正後のコード
            $row = Login::where(['userid' => $request->userid,'password' => $request->password]);

            // dump($row->toSql(), $row->getBindings());
            \Log::info($row->toSql());
            \Log::info($row->getBindings());
            //本来一行で完結するコードだが、sql文の確認のため、あとからfirstを呼び出して、変数へ
            $row = $row->first();

            if (!empty($row)) {
                $id = $row->id;
                Auth::loginUsingId($id);
                return redirect()->intended('/');
            } else {
                return redirect()->route('login')
                ->withErrors(array('userid' => 'ログインに失敗しました。'))
                ->with(["status" => true]);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('auth.register');
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
            'name' => 'required',
            'userid' => 'required|unique:users',
            'password' => 'required|confirmed|max:255',
        ]);
        DB::beginTransaction();
        try {
            $user = new \App\Login();
            $user->name = $request->name;
            $user->userid = $request->userid;
            $user->password = $request->password;
            $user->admin_flag = 0;
            $user->save();
            DB::commit();
        } catch (PDOException $e) {
            DB::rollBack();
        }
        return redirect()->route('login.index');
    }
}
