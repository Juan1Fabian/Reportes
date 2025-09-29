<?php
namespace App\Models;

use CodeIgniter\Model;

class ReportPublisherWeight extends Model
{
    protected $table = 'view_superhero_publisher_weight';
    protected $returnType = 'array';
    public function getAvgWeightByPublisher(string $order = 'ASC'): array
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $builder = $this->db->table($this->table)
            ->select('Marca, Promedio_Peso')
            ->where('Promedio_Peso >', 0)
            ->where("NULLIF(Marca, '') IS NOT NULL", null, false)
            ->orderBy('Promedio_Peso', $order);

        return $builder->get()->getResultArray();
    }
}
