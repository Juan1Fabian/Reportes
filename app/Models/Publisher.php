<?php

namespace App\Models;
use CodeIgniter\Model;

class Publisher extends Model{
  protected $table = "publishers";

  protected $allowedFields = ['id', 'publisher_name'];
}