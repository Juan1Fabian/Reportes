<?php



namespace App\Models;

use CodeIgniter\Model;

class Superhero extends Model
{
    protected $table = "superhero";
    protected $primaryKey = 'id';
    protected $allowedFields = ['superhero_name', 'full_name', 'race_id', 'alignment_id', 'publisher_id'];

    public function getSuperheroesByPublisher(int $publisher_id)
    {
        /* SELECT superhero.id, superhero.superhero_name, superhero.full_name, race.race, alignment.alignment
         FROM superhero
         LEFT JOIN race ON race.id = superhero.race_id
         LEFT JOIN alignment ON alignment.id = superhero.alignment_id
         WHERE superhero.publisher_id = 13
         ORDER BY superhero.superhero_name ASC;
         */
        return $this->select('superhero.id, superhero.superhero_name, superhero.full_name, race.race, alignment.alignment')
                    ->join('race', 'race.id = superhero.race_id', 'left')
                    ->join('alignment', 'alignment.id = superhero.alignment_id', 'left')
                    ->where('superhero.publisher_id', $publisher_id)
                    ->orderBy('superhero.superhero_name', 'ASC')
                    ->findAll();
    }

       public function getSuperheroesByAlignment(int $race_id, int $alignment_id)
        {
            return $this->select('superhero.id, superhero.superhero_name, superhero.full_name, race.race, alignment.alignment')
                        ->join('race', 'race.id = superhero.race_id', 'left')
                        ->join('alignment', 'alignment.id = superhero.alignment_id', 'left')
                        ->orderBy('superhero.superhero_name', 'ASC')
                        ->where('race.id', $race_id) // Use the full table name 'race'
                        ->where('alignment.id', $alignment_id) // Use the full table name 'alignment'
                        ->findAll();
        }
        public function getByGenders(array $genders = [], int $limit = 50): array
        {
            $builder = $this->select('superhero.superhero_name, gender.gender')
                            ->join('gender', 'gender.id = superhero.gender_id', 'left')
                            ->orderBy('superhero.superhero_name', 'ASC');

            if (!empty($genders)) {
                $builder->whereIn('gender.gender', $genders);
            }

            if ($limit > 0) {
                $builder->limit($limit);
            }

            return $builder->findAll();
        }

}