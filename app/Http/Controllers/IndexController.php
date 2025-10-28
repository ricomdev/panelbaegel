<?php

namespace App\Http\Controllers;

// use App\Models\Flavor;
use App\Models\Index;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index(){
        $index = Index::where('id','1')->first();
        //$flavors =Flavor::where('activo','1')->orderBy('nombre')->get();
        return view('pages.index')->with(compact('index'));
    }

    public function dataindex()
    {
        $index = Index::all();
        return $index;
    }

    public function updateindex(Request $request)
    {
        $index = Index::find(1);

        $index->txt_001_he1 = $request->txt_001_he1;
        $index->txt_002_he1 = $request->txt_002_he1;
        $index->btn_he1 = $request->btn_he1;
        $index->url_he1 = $request->url_he1;

        if ($request->hasFile('filehe1')) {
            $archivo = $request->file('filehe1');
            $extension = $archivo->getClientOriginalExtension();
            $nombre1 = 'header1.' . $extension;

            // //Local
//            $ruta_archivo_he1 =  public_path().'/imagenes/headers/';
//            $ruta_he1 =  public_path().'/imagenes/headers/'.$nombre1;
            //produccion
            $ruta_archivo_he1 =  '/home3/baegelpe/public_html/imagenes/headers/';
            $ruta_he1 =  'https://www.baegel.pe/imagenes/headers/'.$nombre1;

            $archivo->move($ruta_archivo_he1, $nombre1);
            $index->ruta_he1 = $ruta_he1;
        }

        $index->txt_001_he2 = $request->txt_001_he2;
        $index->txt_002_he2 = $request->txt_002_he2;
        $index->btn_he2 = $request->btn_he2;
        $index->url_he2 = $request->url_he2;

        if ($request->hasFile('filehe2')) {
            $archivo = $request->file('filehe2');
            $extension = $archivo->getClientOriginalExtension();
            $nombre2 = 'header2.' . $extension;

            // //Local
//            $ruta_archivo_he2 =  public_path().'/imagenes/headers/';
//            $ruta_he2 =  public_path().'/imagenes/headers/'.$nombre2;
            //produccion
            $ruta_archivo_he2 =  '/home3/baegelpe/public_html/imagenes/headers/';
            $ruta_he2 =  'https://www.baegel.pe/imagenes/headers/'.$nombre2;

            $archivo->move($ruta_archivo_he2, $nombre2);
            $index->ruta_he2 = $ruta_he2;
        }

        $index->txt_001_he3 = $request->txt_001_he3;
        $index->txt_002_he3 = $request->txt_002_he3;
        $index->btn_he3 = $request->btn_he3;
        $index->url_he3 = $request->url_he3;

        if ($request->hasFile('filehe3')) {
            $archivo = $request->file('filehe3');
            $extension = $archivo->getClientOriginalExtension();
            $nombre3 = 'header3.' . $extension;

            // //Local
//            $ruta_archivo_he3 =  public_path().'/imagenes/headers/';
//            $ruta_he3 =  public_path().'/imagenes/headers/'.$nombre3;
            //produccion
            $ruta_archivo_he3 =  '/home3/baegelpe/public_html/imagenes/headers/';
            $ruta_he3 =  'https://www.baegel.pe/imagenes/headers/'.$nombre3;

            $archivo->move($ruta_archivo_he3, $nombre3);
            $index->ruta_he3 = $ruta_he3;
        }

        if($index->save()){
            return '1';
        }else{
            return '2';
        }

    }

    public function updateindexqso(Request $request)
    {
        $index = Index::find(1);

        $index->qso_tit = $request->qso_tit;
        $index->qso_sub_tit = $request->qso_sub_tit;
        $index->qso_txt = $request->qso_txt;

        if($index->save()){
            return '1';
        }else{
            return '2';
        }

    }

    public function updatetop(Request $request)
    {
        $index = Index::find(1);

        $index->top_tit = $request->top_tit;
        $index->top_sub_tit = $request->top_sub_tit;
        $index->top_flavor_001 = $request->top_flavor_001;
        $index->top_flavor_002 = $request->top_flavor_002;
        $index->top_flavor_003 = $request->top_flavor_003;

        if($index->save()){
            return '1';
        }else{
            return '2';
        }

    }

    public function updatenov(Request $request)
    {
        $index = Index::find(1);

        $index->nov_tit = $request->nov_tit;
        $index->nov_sub_tit = $request->nov_sub_tit;
        $index->nov_btn = $request->nov_btn;

        if ($request->hasFile('filenov1')) {
            $archivo = $request->file('filenov1');
            $extension = $archivo->getClientOriginalExtension();
            $nombrenov1 = 'nov1.' . $extension;

            // //Local
//            $ruta_archivo_he3 =  public_path().'/imagenes/headers/';
//            $ruta_he3 =  public_path().'/imagenes/headers/'.$nombre3;
            //produccion
            $ruta_archivo_nov1 =  '/home3/baegelpe/public_html/imagenes/novedades/';
            $ruta_nov1 =  'https://www.baegel.pe/imagenes/novedades/'.$nombrenov1;

            $archivo->move($ruta_archivo_nov1, $nombrenov1);
            $index->nov_ruta = $ruta_nov1;
        }

        if($index->save()){
            return '1';
        }else{
            return '2';
        }

    }

    public function updatesabores(Request $request)
    {
        $index = Index::find(1);

        $index->sabores_tit = $request->sabores_tit;
        $index->sabores_sub_tit = $request->sabores_sub_tit;
        $index->sabores_btn = $request->sabores_btn;

        if($index->save()){
            return '1';
        }else{
            return '2';
        }

    }

    public function updateig(Request $request)
    {
        $index = Index::find(1);

        $index->ig_tit = $request->ig_tit;
        $index->ig_sub_tit = $request->ig_sub_tit;
        $index->ig_btn = $request->ig_btn;
        $index->ig_url = $request->ig_url;

        if ($request->hasFile('fileig1')) {
            $archivo = $request->file('fileig1');
            $extension = $archivo->getClientOriginalExtension();
            $nombreig1 = 'ig1.' . $extension;

            // //Local
//            $ruta_archivo_he1 =  public_path().'/imagenes/headers/';
//            $ruta_he1 =  public_path().'/imagenes/headers/'.$nombre1;
            //produccion
            $ruta_archivo_ig1 =  '/home3/baegelpe/public_html/imagenes/instagram/';
            $ruta_ig1 =  'https://www.baegel.pe/imagenes/instagram/'.$nombreig1;

            $archivo->move($ruta_archivo_ig1, $nombreig1);
            $index->ig_ruta_001 = $ruta_ig1;
        }

        if ($request->hasFile('fileig2')) {
            $archivo = $request->file('fileig2');
            $extension = $archivo->getClientOriginalExtension();
            $nombreig2 = 'ig2.' . $extension;

            // //Local
//            $ruta_archivo_he2 =  public_path().'/imagenes/headers/';
//            $ruta_he2 =  public_path().'/imagenes/headers/'.$nombre2;
            //produccion
            $ruta_archivo_ig2 =  '/home3/baegelpe/public_html/imagenes/instagram/';
            $ruta_ig2 =  'https://www.baegel.pe/imagenes/instagram/'.$nombreig2;

            $archivo->move($ruta_archivo_ig2, $nombreig2);
            $index->ig_ruta_002 = $ruta_ig2;
        }

        if ($request->hasFile('fileig3')) {
            $archivo = $request->file('fileig3');
            $extension = $archivo->getClientOriginalExtension();
            $nombreig3 = 'ig3.' . $extension;

            // //Local
//            $ruta_archivo_he3 =  public_path().'/imagenes/headers/';
//            $ruta_he3 =  public_path().'/imagenes/headers/'.$nombre3;
            //produccion
            $ruta_archivo_ig3 =  '/home3/baegelpe/public_html/imagenes/instagram/';
            $ruta_ig3 =  'https://www.baegel.pe/imagenes/instagram/'.$nombreig3;

            $archivo->move($ruta_archivo_ig3, $nombreig3);
            $index->ig_ruta_003 = $ruta_ig3;
        }

        if ($request->hasFile('fileig4')) {
            $archivo = $request->file('fileig4');
            $extension = $archivo->getClientOriginalExtension();
            $nombreig4 = 'ig4.' . $extension;

            // //Local
//            $ruta_archivo_he4 =  public_path().'/imagenes/headers/';
//            $ruta_he4 =  public_path().'/imagenes/headers/'.$nombre4;
            //produccion
            $ruta_archivo_ig4 =  '/home3/baegelpe/public_html/imagenes/instagram/';
            $ruta_ig4 =  'https://www.baegel.pe/imagenes/instagram/'.$nombreig4;

            $archivo->move($ruta_archivo_ig4, $nombreig4);
            $index->ig_ruta_004 = $ruta_ig4;
        }

        if ($request->hasFile('fileig5')) {
            $archivo = $request->file('fileig5');
            $extension = $archivo->getClientOriginalExtension();
            $nombreig5 = 'ig5.' . $extension;

            // //Local
//            $ruta_archivo_he5 =  public_path().'/imagenes/headers/';
//            $ruta_he5 =  public_path().'/imagenes/headers/'.$nombre5;
            //produccion
            $ruta_archivo_ig5 =  '/home3/baegelpe/public_html/imagenes/instagram/';
            $ruta_ig5 =  'https://www.baegel.pe/imagenes/instagram/'.$nombreig5;

            $archivo->move($ruta_archivo_ig5, $nombreig5);
            $index->ig_ruta_005 = $ruta_ig5;
        }

        if ($request->hasFile('fileig6')) {
            $archivo = $request->file('fileig6');
            $extension = $archivo->getClientOriginalExtension();
            $nombreig6 = 'ig6.' . $extension;

            // //Local
//            $ruta_archivo_he6 =  public_path().'/imagenes/headers/';
//            $ruta_he6 =  public_path().'/imagenes/headers/'.$nombre6;
            //produccion
            $ruta_archivo_ig6 =  '/home3/baegelpe/public_html/imagenes/instagram/';
            $ruta_ig6 =  'https://www.baegel.pe/imagenes/instagram/'.$nombreig6;

            $archivo->move($ruta_archivo_ig6, $nombreig6);
            $index->ig_ruta_006 = $ruta_ig6;
        }

        if($index->save()){
            return '1';
        }else{
            return '2';
        }

    }


}
