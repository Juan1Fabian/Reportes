<?php
namespace App\Models;

use CodeIgniter\Model;

class ReportPublisher extends Model
{
    protected $table = 'view_superhero_publisher';
    protected $primaryKey = 'publisher_id';
    protected $returnType = 'array';
    protected $allowedFields = [];

    public function getCounts(array $publishers = []): array
    {
        $builder = $this->builder();
        if (!empty($publishers)) {
            // La vista expone 'Marca' (publisher_name) y 'Total_Heroes'
            $builder->whereIn('Marca', $publishers);
        }
        return $builder->get()->getResultArray();
    }
}
