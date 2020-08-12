<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Model\Persona;

class PersonaController extends Controller
{

    public function index()
    {
        $personas = Persona::get();
        return response()->json($personas);
    }

    public function store(Request $request)
    {
        $this->validate($request,[            
            'tipo_persona'=>'required',
            'nombre'=>'required'
        ]);

        $p = new Persona();
        $p->tipo_persona = $request->tipo_persona;
        $p->nombre = $request->nombre;

        $p->save();
        return response()->json(['success'=>'Add Persona']);
    }

    public function show($id)
    {
        $persona = Persona::where('id',$id)->first();
        return response()->json($persona);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[            
            'tipo_persona'=>'required',
            'nombre'=>'required'
        ]);

        $p = Persona::where('id',$id)->first();
       
        $p->tipo_persona = $request->tipo_persona;
        $p->nombre = $request->nombre;

        $p->save();
        return response()->json(['success'=>'Update Persona']);      
    }

    public function destroy($id)
    {
        $persona = Persona::where('id',$id)->first();
        $persona->delete();
    }

}
