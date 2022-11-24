<?php

namespace App\Http\Controllers;

use App\Models\PermissionRole;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    public function index()
    {
        return response()->json(PermissionRole::all(), 200);
    }

    public function show($id)
    {
        $the_permission_role = PermissionRole::find($id);
        if (is_null($the_permission_role)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            return response()->json($the_permission_role, 200);
        }
    }

    public function store(Request $request)
    {
        $the_permission_role = PermissionRole::create($request->all());
        return response($the_permission_role, 201);
    }

    public function update(Request $request, $id)
    {
        $the_permission_role = PermissionRole::find($id);
        if (is_null($the_permission_role)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_permission_role->update($request->all());
            return response()->json($the_permission_role::find($id), 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        $the_permission_role = PermissionRole::find($id);
        if (is_null($the_permission_role)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_permission_role->delete();
            return response()->json(null, 204);
        }
    }
}
