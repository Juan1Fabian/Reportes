<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use Spipu\Html2Pdf\Html2Pdf;

use App\Models\ReportAlignment;
use App\Models\ReporteGender;
use App\Models\ReportPublisher;
use App\Models\Superhero;
use App\Models\Publisher;
use App\Models\ReportPublisherWeight;

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
            'message'=>'Popularidad',
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

    public function getGenero()
    {
        return view('dashboard/getGenero');
    }

    public function VistaPdf()
    {
        $genders = $this->request->getVar('genders');
        if (is_string($genders) && $genders !== '') {
            $genders = [$genders];
        }
        $limit = (int)($this->request->getVar('limit') ?? 50);
        $limit = max(1, min(200, $limit));
        $filenameInput = trim((string)$this->request->getVar('filename'));

        $superhero = new Superhero();
        $rows = $superhero->getByGenders(is_array($genders) ? $genders : [], $limit);

        $data = [
            'title' => $filenameInput ?? 'Reporte SH 2025',
            'limit' => $limit,
            'rows' => $rows,
        ];

        $html = view('dashboard/genderReporte', $data);

        $filename = $filenameInput !== '' ? $filenameInput . '.pdf' : 'Reporte_Generos_' . date('Ymd_His') . '.pdf';

        $html2pdf = new Html2Pdf('P', 'A4', 'es');
        $html2pdf->writeHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $html2pdf->output($filename);
    }

    public function genderReport()
    {
        $selected = $this->request->getVar('genders');
        $filenameInput = $this->request->getVar('filename');

        $reportGender = new ReporteGender();
        if ($selected && is_array($selected)) {
            $data = $reportGender->whereIn('gender', $selected)->findAll();
        } else {
            $data = $reportGender->findAll();
        }

        $filename = $filenameInput
            ? $filenameInput . '.pdf'
            : 'Reporte_Generos_' . date('Ymd_His') . '.pdf';

        $html = view('dashboard/genderReporte', ['resumen' => $data]);

        $html2pdf = new Html2Pdf('P', 'A4', 'es');
        $html2pdf->writeHTML($html);
        $html2pdf->output($filename, 'D');
    }
    
    public function getInformePublishers()
    {
        $publisher = new Publisher();
        $data = [
            'publishers' => $publisher->findAll(),
        ];
        return view('dashboard/PublisherCont', $data);
    }

    public function getDataPublishers()
    {
        $this->response->setContentType('application/json');

        $selected = $this->request->getVar('publishers');
        if (is_string($selected) && $selected !== '') {
            $selected = [$selected];
        }

        $data = new ReportPublisher();
        $rows = (is_array($selected) && !empty($selected))
            ? $data->getCounts($selected)
            : $data->findAll();

        if (!$rows) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sin datos de publishers',
                'resumen' => []
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Héroes por publisher',
            'resumen' => $rows
        ]);
    }

    public function getInformeAvgWeight()
    {
        return view('dashboard/PublisherWeight');
    }

    public function getDataAvgWeightByPublisher()
    {
        $this->response->setContentType('application/json');
        $order = strtoupper((string)($this->request->getVar('order') ?? 'ASC'));
        $order = $order === 'DESC' ? 'DESC' : 'ASC';

        $model = new ReportPublisherWeight();
        $rows = $model->getAvgWeightByPublisher($order);

        if (!$rows) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sin datos de promedio de peso',
                'resumen' => []
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Promedio de peso por publisher (' . $order . ')',
            'resumen' => $rows
        ]);
    }
}