<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index() {
        if(Auth::user()->type == 'admin') {
            $users = User::all();
            return view('auth.users.index', compact('users'));
        } else {
            return redirect('home');
        }
    }

    public function addUser() {
        return view('auth.users.adduser');
    }

    public function create(Request $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->status = $request->status;
        $user->password = bcrypt($request->password);
        if($user->save()) {
            return response()->json(['success' => true, 'message' => 'User created successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'User creation failed']);
        }
    }

    public function update(Request $request) {
        $usersUpdate = User::where('id', '=', $request->id)->update([
            'name' => $request->name, 
            'email' => $request->email, 
            'type' => $request->type, 
            'status' => $request->status
        ]);

        if($usersUpdate) {
            return response()->json(['success' => true, 'message' => 'User updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'User update failed']);
        }
    }

    public function delete(Request $request) {
        $usersDelete = User::where('id', '=', $request->id)->delete();

        if($usersDelete) {
            return redirect('users')->with('success', 'User deleted successfully');
        } else {
            return redirect('users')->with('error', 'User deletion failed');
        }
    }

    public function exportCsv() {
        $fileName = "users.csv";
        $users = User::all();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre",
            "Expires" => "0"
        );

        $columns = array('id', 'name', 'email', 'type', 'status', 'created_at', 'updated_at');

        $callback = function() use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($users as $user) {
                fputcsv($file, array(
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->type,
                    $user->status,
                    $user->created_at,
                    $user->updated_at
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}