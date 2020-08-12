<?php

namespace App\Http\Controllers\Api;

use App\Model\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    public function todayPrestamo(){ //index del día
        $prestamos = DB::table('prestamos')
            ->join('personas','prestamos.persona_id','personas.id')
            ->select('personas.nombre','prestamos.*')
            ->where('prestamos.prestamo_date',date('d/m/Y'))->orderBy('prestamos.id','DESC')->get();
        return response()->json($prestamos);
    }
    public function prestamoInfo($id){ //show
        $prestamos = DB::table('prestamos')
            ->join('personas','prestamos.persona_id','personas.id')
            ->where('prestamos.id',$id)->first();
        return response()->json($prestamos);
    }
    public function prestamoDetails($id){ //show
        $prestamoDetails= DB::table('prestamo_details')
            ->join('dispositivos','prestamo_details.dispositivo_id','dispositivos.id')
            ->where('prestamo_details.prestamo_id',$id)->get();
        return response()->json($prestamoDetails);
    }
    public function prestamos(){ //index
        $prestamos = DB::table('prestamos')
            ->join('personas','prestamos.persona_id','personas.id')
            ->select('personas.nombre','prestamos.*')
            ->orderBy('prestamos.id','DESC')
            ->get();
        return response()->json($prestamos);
    }
    public function prestamoDelete($id){ 
        $details = DB::table('prestamo_details')->where('prestamo_id',$id)->get();
        foreach ($details as $detail){
            DB::table('prestamo_details')->delete($detail->id);
        }
        DB::table('prestamos')->delete($id);
        return response()->json(['success'=>'Prestamos & Prestamo Details Data Deleted!']);
    }
    public function prestamoDate(Request $request){
        $this->validate($request,['date'=>'required']);
        $date = Carbon::parse($request->date)->format('d/m/Y');

        $prestamos = DB::table('prestamos')
            ->join('personas','prestamos.persona_id','personas.id')
            ->select('personas.nombre','prestamos.*')
            ->where('prestamos.prestamo_date',$date)->get();
        return response()->json($prestamos);
    }

    public function prestamoMonth(Request $request){
        $this->validate($request,['month'=>'required']);
        $month = $request->month;
        $prestamos = DB::table('prestamos')
            ->join('personas','prestamos.persona_id','personas.id')
            ->select('personas.nombre','prestamos.*')
            ->where('prestamos.prestamo_month',$month)->get();
        return response()->json($prestamos);
    }
}
