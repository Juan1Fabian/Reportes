<?php
namespace App\Models;
use CodeIgniter\Model;

class ReportAlignment extends Model{

  protected $table = "view_superhero_alignment";
  protected $primaryKey = "alignment";
  protected $returnType = "array";
  protected $allowedFields = [];
}