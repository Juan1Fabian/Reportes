<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Alignment;
use App\Models\Race;
use App\Models\Publisher;
use CodeIgniter\Commands\Utilities\Publish;
use Exception;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use App\Models\Superhero;

class ReporteController extends BaseController
{
  public $db;


  
    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

    public function showUIreporte(){
      $publicher = new Publisher();
      $race = new Race();
      $alignment = new Alignment();

      $datos = [
        "publishers"=> $publicher->findAll(),
        "races"=> $race->findAll(),
        "alignment"=> $alignment->findAll()
      ];
     
      return view('reporte/rpt-ui', $datos);
    }

    public function getReportByPublisher(){
    $superhero = new Superhero();
    // Corregir la llamada al método para que coincida con el modelo
    $publisher_id = intval($this->request->getVar('publisher_id')) ;

    $datos = [
      'estilos' => view('reporte/estilos'),
      'superheros' => $superhero->getSuperheroesByPublisher(1)
    ];

    $html = view('reporte/rpt-superhero', $datos);

     try {
        $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', [20, 10, 10, 10]);
        $html2pdf->writeHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $html2pdf->output('Reporte3.pdf');
        // exit(); //Opcional
          
        } catch (Html2PdfException $e) {
          $html2pdf->clean();
          $formatter = new ExceptionFormatter($e);
          echo $formatter->getMessage();
        }
}

public function getReportByRaceAlignment(): void
{
    $superhero = new Superhero();
    
    // Obtiene los valores de los parámetros de la solicitud
    $race_id = intval(value: $this->request->getVar(index: 'race_id'));
    $alignment_id = intval(value: $this->request->getVar(index: 'alignment_id'));
    
    // Datos a enviar a la vista
    $datos = [
        'estilos' => view(name: 'reporte/estilos'),
        'superheros' => $superhero->getSuperHeroByRaceAlignment(race_id: $race_id, alignment_id: $alignment_id)
    ];
    
    // Genera el HTML para el reporte
    $html = view(name: 'reportes/rpt-superhero-ra', data: $datos);

    // Configuración y generación del PDF usando HTML2PDF
     try {
        $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', [20, 10, 10, 10]);
        $html2pdf->writeHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $html2pdf->output('Reporte3.pdf');
        // exit(); //Opcional
          
        } catch (Html2PdfException $e) {
          $html2pdf->clean();
          $formatter = new ExceptionFormatter($e);
          echo $formatter->getMessage();
        }
}

    

    public function getReporte1()
    {
        $html = view('reporte/reporte1');

        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $html2pdf->output();
    }

    public function getReporte2()
    {
      $data = [
        "area" => "Finanzas",
        "autor" => "Juan Perez",

        "productos" => [
          ["id"=>1, "nombre"=>"Teclado", "precio"=>100],
          ["id"=>2, "nombre"=>"Mouse", "precio"=>50],
          ["id"=>3, "nombre"=>"Teclado", "precio"=>100],
        ],
        "estilos" => view('reporte/estilos'),
      ];

      $html = view('reporte/reporte2',$data);
      try {
        $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', [10, 10, 10, 10]);
        $html2pdf->writeHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $html2pdf->output('Reporte-Finanzas.pdf');
        // exit(); //Opcional
          
        } catch (Html2PdfException $e) {
          $html2pdf->clean();
          $formatter = new ExceptionFormatter($e);
          echo $formatter->getMessage();
        }

    }

    public function getReporte3()
    {

      $query = "
      SELECT
      SH.id,
      SH.superhero_name,
      SH.full_name,
      PB.publisher_name,
      AL.alignment
      FROM superhero SH
      LEFT JOIN publisher PB ON SH.publisher_id = PB.id
      LEFT JOIN alignment AL ON SH.alignment_id = AL.id
      ORDER BY 4
      LIMIT 100";

      $row = $this->db->query($query);
      $data = ["rows" => $row->getResultArray(),
                "estilos" => view('reporte/estilos'),];
      $html = view('reporte/reporte3',$data);
      try {
        $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', [10, 10, 10, 10]);
        $html2pdf->writeHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $html2pdf->output('Reporte3.pdf');
        // exit(); //Opcional
          
        } catch (Html2PdfException $e) {
          $html2pdf->clean();
          $formatter = new ExceptionFormatter($e);
          echo $formatter->getMessage();
        }
    }

    public function getFiltro($publisherName)
    {
        $query = '
            SELECT
                SH.id,
                SH.superhero_name,
                SH.full_name,
                PB.publisher_name,
                AL.alignment
            FROM superhero SH
            LEFT JOIN publisher PB ON SH.publisher_id = PB.id
            LEFT JOIN alignment AL ON SH.alignment_id = AL.id
            WHERE PB.publisher_name = ?
            ORDER BY PB.publisher_name;
        ';

        // Ejecutar la consulta pasando el parámetro para evitar inyección SQL
        $result = $this->db->query($query, [$publisherName]);

        // Retornar resultados como array
        return $result->getResultArray();
    }

    public function getPublishers()
    {
        $query = 'SELECT id, publisher_name FROM publisher ORDER BY publisher_name ASC';
        $result = $this->db->query($query);
        return $result->getResultArray();
    }

    // Método para mostrar el formulario de filtro
    public function filtro()
    {
        $publishers = $this->getPublishers();

        // Pasar los datos a la vista
        echo view('reporte/filtro', ['publishers' => $publishers]);
    }

    // Método para generar el PDF con el filtro
    public function getReporte4()
    {
        $publisherName = $this->request->getGet('publisher');

        if (!$publisherName) {
            return redirect()->back()->with('error', 'Selecciona un editor');
        }

        $superheroes = $this->getFiltro($publisherName);

        // Crear contenido HTML para el PDF
        $html = view('reporte/reporte4', ['superheroes' => $superheroes, 'publisherName' => $publisherName, 'estilos' => view('reporte/estilos')]);
        try {
            $html2pdf = new Html2Pdf('P', 'A4', 'es');
            $html2pdf->writeHTML($html);
            $html2pdf->output('reporte_superheroes_'.$publisherName.'.pdf');
            exit(); // Opcional
        } catch (Html2PdfException $e) {
            echo $e->getMessage();
            exit;
        }
      }
}