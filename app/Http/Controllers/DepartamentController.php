<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartamentController extends Controller
{
    public function index() {
        $departaments = Departament::all();
        return response()->json($departaments); 
    }
    public function store(Request $request) {
        $rules = [
            'name' => 'required|string|min:3|max:100'
        ];
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $departament = new Departament($request->all());
        $departament->save();
        return response()->json($departament, 201);

    }
    public function show(Departament $departament) {
        return response()->json($departament);
    }
    public function update(Request $request, Departament $departament) {
        $rules = [
            'name' => 'required|string|min:3|max:100'
        ];
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $departament->update($request->all());
        return response()->json($departament, 200);
    }
    public function destroy(Departament $departament) {
        $departament->delete();
        return response()->json(null, 204);
    }
}
