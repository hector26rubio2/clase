<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return response()->json(Permission::all(), 200);
    }

    public function show($id)
    {
        $the_permission = Permission::find($id);
        if (is_null($the_permission)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_permission->roles;
            return response()->json($the_permission, 200);
        }
    }

    public function store(Request $request)
    {
        $the_permission = Permission::create($request->all());
        return response($the_permission, 201);
    }

    public function update(Request $request, $id)
    {
        $the_permission = Permission::find($id);
        if (is_null($the_permission)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_permission->update($request->all());
            return response()->json($the_permission::find($id), 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        $the_permission = Permission::find($id);
        if (is_null($the_permission)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_permission->delete();
            return response()->json(null, 204);
        }
    }
}
