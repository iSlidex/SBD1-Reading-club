<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use DB;

class GenerateReportsController extends Controller
{
    public function bookform(){
        return view ('reports.generate_reports.generate_book_report');
    }

    public function clubform(Request $request){
        if ($request->ajax()){
            $clubs = DB::select(DB::raw("SELECT c.id, c.nom as nombre, c.fec_crea as fecha_de_creacion, (
                SELECT nom FROM sjl_idiomas WHERE id = c.id_idiom
            )idioma FROM sjl_clubes_lectura c"));
            return Response::json(array('data'=>$clubs));
        }
        else
            return view ('reports.generate_reports.generate_club_report');
    }
    public function clubformbook(Request $request){
        if ($request->ajax()){
            $clubs = DB::select(DB::raw("SELECT c.id, c.nom as nombre, c.fec_crea as fecha_de_creacion, (
                SELECT nom FROM sjl_idiomas WHERE id = c.id_idiom
            )idioma FROM sjl_clubes_lectura c"));
            return Response::json(array('data'=>$clubs));
        }
        else
            return view ('reports.generate_reports.generate_clubbook_report');
    }
    public function clubformmember(Request $request,$id){
        if ($request->ajax()){
            $members = DB::select(DB::raw("SELECT doc_iden, nom1 as nom, ape1 as ape, fec_nac, id_club FROM sjl_lectores WHERE id_club = '$id'"));
            if ($request->ajax()){
                return Response::json(array('members'=>$members,'club'=>$id));
            }
            else{
                return view ('reports.clubmember');
            }
        }
        else
            return view ('reports.clubmember');
    }
    public function clubformmemberpon(Request $request){
        if ($request->ajax()){
            $members = DB::select(DB::raw("SELECT doc_iden, nom1 as nom, ape1 as ape, fec_nac, id_club FROM sjl_lectores WHERE id_club = '$id'"));
            if ($request->ajax()){
                return Response::json(array('members'=>$members,'club'=>$id));
            }
            else{
                return view ('reports.generate_reports.generate_clubmember_report');
            }
        }
        else
            return view ('reports.generate_reports.generate_clubmember_report');
    }
    
    public function attendanceform(Request $request){
        if ($request->ajax()){
            $clubs = DB::select(DB::raw("SELECT c.id, c.nom as nombre, c.fec_crea as fecha_de_creacion, (
                SELECT nom FROM sjl_idiomas WHERE id = c.id_idiom
            )idioma FROM sjl_clubes_lectura c"));
            return Response::json(array('data'=>$clubs));
        }
        else
            return view ('reports.generate_reports.generate_attendance_report');
    }

    public function attendanceformg(Request $request, $idclub){
        return view ('reports.generate_reports.generate_attendanceg_report')->with('idclub',$idclub);
    }

    public function attendanceformgetgroups(Request $request, $idclub){
        if ($request->ajax()){
            $groups = DB::select(DB::raw("SELECT g.id,g.nom as nombre, (
                CASE WHEN g.dia_sem=2 THEN 'Lunes'
                WHEN g.dia_sem = 3 THEN 'Martes'
                WHEN g.dia_sem = 4 THEN 'Miercoles'
                WHEN g.dia_sem = 5 THEN 'Jueves'
                ELSE 'Viernes'
            END) as dia_disponible,  (select to_char(hora_i::time, 'HH12:MI AM')) || ' - ' || (select to_char(hora_f::time, 'HH12:MI AM')) as horario_disponible  FROM sjl_grupos_lectura g WHERE g.id_club='$idclub'"));
            return Response::json(array('data'=>$groups));
        }
    }

    public function clubperform(Request $request){
        if ($request->ajax()){
            $clubs = DB::select(DB::raw("SELECT c.id, c.nom as nombre, c.fec_crea as fecha_de_creacion, (
                SELECT nom FROM sjl_idiomas WHERE id = c.id_idiom
            )idioma FROM sjl_clubes_lectura c"));
            return Response::json(array('data'=>$clubs));
        }
        else
            return view ('reports.generate_reports.generate_clubperform_report');
    }
    public function playsform(Request $request){

        if($request->ajax()){
            $obras = DB::select(DB::raw("SELECT o.id, o.nom as obra, o.resum as resumen, (
                SELECT l.titulo_esp FROM sjl_libros l WHERE l.isbn = ol.id_lib AND o.id = ol.id_obra
            )libro_base FROM sjl_obras o, sjl_obras_libros ol WHERE o.id = ol.id_obra"));
            return Response::json(array('data'=>$obras));
        }
        else{
            return view('reports.generate_reports.generate_plays_report');
        }
    }
    
}
