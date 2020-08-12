<?php

namespace App\Http\Controllers\Api;

use App\Model\Dispositivo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PopController extends Controller
{
    public function prestamoStore(Request $request){
        $this->validate($request,[
            'persona_id'=>'required',
        ]);

        $data=[];
        $data['persona_id']=$request->persona_id;
        $data['carrito_quantity']=$request->carrito_quantity;
        $data['prestamo_date']=date('d/m/Y');
        $data['prestamo_month']=date('F');
        $data['prestamo_year']=date('Y');

        $prestamo_id = DB::table('prestamos')->insertGetId($data);
        $carritos = DB::table('carritos')->get();
        foreach ($carritos as $carrito){
           $prestamoData=[];
           $prestamoData['prestamo_id']=$prestamo_id;
           $prestamoData['dispositivo_id']=$carrito->dispositivo_id;
           $prestamoData['dispositivo_quantity']=$carrito->dispositivo_quantity;
           DB::table('prestamo_details')->insert($prestamoData);
           DB::table('dispositivos')->where('id',$carrito->dispositivo_id)->update(['d_quantity'=>DB::raw('d_quantity -'.$carrito->dispositivo_quantity)]);
        }
        DB::table('carritos')->delete();
        return response()->json(['success'=>'Successfully Prestamo Complete!']);
    }
}
