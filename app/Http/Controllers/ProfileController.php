<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json(Profile::all(), 200);
    }

    public function show($id)
    {
        $the_pofile = Profile::find($id);
        if (is_null($the_pofile)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            return response()->json($the_pofile, 200);
        }
    }

    public function store(Request $request)
    {
        if ($request->file('image') && ($request->file("image")->getClientOriginalExtension() == "jpg" ||
            $request->file("image")->getClientOriginalExtension() == "png")) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $request->user_id . "-" . time() . '.' . $extension;
            $url = $file->move('avatars', $filename);
        } else {
            return response(['message' => 'Se debe cargar una imagen'], 400);
        }

        try {
            $the_pofile = Profile::where('user_id', '=', $request->user_id)->first();
            if (is_null($the_pofile)) {
                $data = $request->all();
                $data['url_avatar'] = $url;
                $the_pofile = Profile::create($data);
                return response($the_pofile, 201);
            }
        } catch (Exception   $e) {
            echo $e->getMessage();
            return response()->json(['message' => 'Interna server error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $the_pofile = Profile::find($id);
        if (is_null($the_pofile)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_pofile->update($request->all());
            return response()->json($the_pofile::find($id), 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        $the_pofile = Profile::find($id);
        if (is_null($the_pofile)) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $the_pofile->delete();
            return response()->json(null, 204);
        }
    }

    public function count($id){
        $SQLconsulta = "SELECT countRoles($id) as value";
        $consulta = DB::select($SQLconsulta, array());
        return $consulta;
    }

    public function quantitiesByRoles(){
        $SQLconsulta = "call quantity_by_role()";
        $consulta = DB::select($SQLconsulta, array());
        return $consulta;
    }
}
