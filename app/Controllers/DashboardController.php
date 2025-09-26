<?php

namespace App\Controllers;
use App\Controllers\BaseController;

use App\Models\ReportAlignment;

class DashboardController extends BaseController
{
    public function getinforme01()
    {
    return view('dashboard/informe01');
    }
    public function getinforme02()
    {
    return view('dashboard/informe02');
    }
    public function getinforme03()
    {
    return view('dashboard/informe03');
    }
    public function getinforme04()
    {
    return view('dashboard/informe04');
    }

    //Retorna JSON que requiere la vista
    public function getDataInforme2(){
        $this->response->setContentType("application/json");

        $data = [
            ["superhero" => "Batman","popularidad" => 50],
            ["superhero" => "BlakPanter","popularidad" => 20],
            ["superhero" => "Robin","popularidad" => 40],
            ["superhero" => "Homelander","popularidad" => 60],
            ["superhero" => "Goku","popularidad" => 100],
            ["superhero" => "Superman","popularidad" => 50],
        ];
        if(!$data){
            return $this->response->setJSON([
                'success' => false,
                'message'=> 'No encontramos superheroes',
                'resumen' => []
            ]);
        }
        return $this->response->setJSON([
            'success'=> true,
            'message'=>'Popilaridad',
            'resumen'=>$data
        ]);
    }

    public function getDataInforme3(){
        $this->response->setContentType('application/json');
        $reporteAlignment = new ReportAlignment();
        $data = $reporteAlignment->findAll();

        if(!$data){
            return $this->response->setJSON([
                'success' => false,
                'message'=> 'No encontramos superheroes',
                'resumen' => []
            ]);
        }
        return $this->response->setJSON([
            'success'=> true,
            'message'=>'Popilaridad',
            'resumen'=>$data
        ]);
    }

    public function getDataInforme3Cache()
    {
        $this->response->setContentType('application/json');
        $cachekey = 'resumenAlignment';

        $data = cache($cachekey);

        // Si no hay datos en cache, consultamos y guardamos
        if ($data === null) {
            $reportAlignment = new ReportAlignment();
            $data = $reportAlignment->findAll();

            cache()->save($cachekey, $data, 3600);
        }

        if (!$data) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No encontramos super heroes',
                'resumen' => []
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Alineacion',
            'resumen' => $data
        ]);
    }
}