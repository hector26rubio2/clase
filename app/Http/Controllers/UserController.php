<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function show($id)
    {
        $the_user = User::find($id);
        if (is_null($the_user)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_user->profile;
            $the_user->role;
            return response()->json($the_user, 200);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'role_id' => 'required',
            ]);
            $data['password'] = bcrypt($request->password);
            $user = User::create($data);
            $token = $user->createToken('Token Name')->accessToken;
            return response(['user' => $user, 'token' => $token]);
        } catch (Exception $e) {
            echo $e->getMessage();
            return response(['data' => "Data incomplete "], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $the_user = User::find($id);
        if (is_null($the_user)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_user->update($request->all());
            return response()->json($the_user::find($id), 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        $the_user = User::find($id);
        if (is_null($the_user)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_user->delete();
            return response()->json(null, 204);
        }
    }
}
