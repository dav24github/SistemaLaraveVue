<?php

namespace App\Http\Controllers\Api;

use App\Model\Dispositivo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function addToCarrito($id){
        $dispositivo = Dispositivo::findOrfail($id);
        $sameDispositivoCheck = DB::table('carritos')->where('dispositivo_id',$id)->first();
        if($sameDispositivoCheck){
            if($sameDispositivoCheck->dispositivo_quantity < $dispositivo->d_quantity){
                DB::table('carritos')->where('dispositivo_id',$id)->increment('dispositivo_quantity');
            }else{
                return response()->json(['error'=>'Can not increment. out of stack']);
            }

        }else{
            $data = [];
            $data['dispositivo_id']=$id;
            $data['dispositivo_name']=$dispositivo->nombre;
            $data['dispositivo_quantity']=1;
            DB::table('carritos')->insert($data);
            return response()->json(['success'=>'Carrito added']);
        }
    }
    public function getCarritos(){
        $carritos = DB::table('carritos')->get();
        return response()->json($carritos);
    }
    public function carritoRemove($id){
        $carrito = DB::table('carritos')->delete($id);
        return response()->json(['success'=>'Carrito deleted']);
    }
    public function carritoIncrement($id){
         $newCarrito = DB::table('carritos')->find($id);
         $dispositivo_id = $newCarrito->dispositivo_id;
         $dispositivo = Dispositivo::find($dispositivo_id);
         $dispositivo_quantity = $dispositivo->d_quantity;
         if($newCarrito->dispositivo_quantity < $dispositivo_quantity){
             DB::table('carritos')->where('id',$id)->increment('dispositivo_quantity');            
             return response()->json($id);
         }else{
             return response()->json(['error'=>'Can not increment. out of stack']);
         }
    }
    public function carritoDecrement($id){
        DB::table('carritos')->where('id',$id)->decrement('dispositivo_quantity');      
        return response()->json($id);
    }
    public function carritoQuantity(){
        $carritoQuantity = DB::table('carritos')->sum('dispositivo_quantity');
        return response()->json($carritoQuantity);
    }
}
