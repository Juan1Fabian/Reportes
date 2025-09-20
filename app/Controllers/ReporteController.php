<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class ReporteController extends BaseController
{
  public $db;


  
    public function __construct()
    {
      $this->db = \Config\Database::connect();
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

    public function buscar()
    {
        $nombre = $this->request->getGet('nombre');

        $sql = "
            SELECT 
                SH.id,
                SH.superhero_name,
                SH.full_name,
                PB.publisher_name,
                AL.alignment,
                GROUP_CONCAT(SP.power_name SEPARATOR ', ') AS poderes
            FROM superhero.superhero SH
            LEFT JOIN superhero.publisher PB ON SH.publisher_id = PB.id
            LEFT JOIN superhero.alignment AL ON SH.alignment_id = AL.id
            LEFT JOIN superhero.hero_power HP ON SH.id = HP.hero_id
            LEFT JOIN superhero.superpower SP ON HP.power_id = SP.id
            WHERE (? IS NULL OR SH.superhero_name LIKE ?)
            GROUP BY SH.id, SH.superhero_name, SH.full_name, PB.publisher_name, AL.alignment
        ";

        $like = $nombre ? "%$nombre%" : null;
        $query = $this->db->query($sql, [$nombre, $like]);
        $result = $query->getResultArray();

        return view('reporte/filtroR5', ['heroes' => $result, 'nombre' => $nombre, 'estilos' => view('reporte/estilos')]);
    }

    public function getReporte5()
    {
        $id = $this->request->getPost('id'); 

        // Traer poderes del héroe
        $powers = $this->db->query("
            SELECT sp.power_name 
            FROM superpower sp
            INNER JOIN hero_power hp ON sp.id = hp.power_id
            WHERE hp.hero_id = ?", [$id]
        )->getResultArray();

        $hero = $this->db->query("SELECT superhero_name FROM superhero WHERE id = ?", [$id])->getRowArray();

        // Renderizar solo la lista de poderes en la vista reporte5
        $html = view('reporte/reporte5', [
            'powers' => $powers,
            'hero' => $hero,
            'estilos' => view('reporte/estilos')
        ]);

        try {
            $html2pdf = new Html2Pdf('P', 'A4', 'es');
            $html2pdf->writeHTML($html);
            $html2pdf->output('poderes_heroe_'.$id.'.pdf', 'I'); 
            // "I" = abrir en el navegador
            exit;
        } catch (Html2PdfException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}