<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Model\Dispositivo;

class DispositivoController extends Controller
{
    public function index()
    {
        $dispositivos = Dispositivo::get();
        return response()->json($dispositivos);
    }

    public function store(Request $request)
    {
        $this->validate($request,[            
            'nombre'=>'required',
            'd_quantity'=>'required'
        ]);
        
        $d = new Dispositivo();
        $d->nombre = $request->nombre;
        $d->d_quantity = $request->d_quantity;
        $d->save();
        return response()->json(['success'=>'Add Dispositivo']);
    }

    public function show($id)
    {
        $dispositivo = Dispositivo::where('id',$id)->first();
        return response()->json($dispositivo);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[            
            'nombre'=>'required',
            'd_quantity'=>'required'
        ]);

        $d = Dispositivo::where('id',$id)->first();
       
        $d->nombre = $request->nombre;
        $d->d_quantity = $request->d_quantity;

        $d->save();
        return response()->json(['success'=>'Update Dispositivo']);      
    }

    public function destroy($id)
    {
        $dispositivo = Dispositivo::where('id',$id)->first();
        $dispositivo->delete();
    }

}
