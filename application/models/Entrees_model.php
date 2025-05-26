<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Booking_model (Booking Model)
 * Booking model class to get to handle booking related data 
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 18 Jun 2022
 */

class Entrees_model extends CI_Model {

    protected $table = 'tbl_services_entrees';

   public function get_all() {
            $query = $this->db->get($this->table);
            $result = [];

            foreach ($query->result() as $row) {
                // On ignore les entrées sans heure prévue
                if (!empty($row->heurePrevu)) {
                    $start = $row->heurePrevu;
                    $timestamp = strtotime($start);

                    // Juste au cas où strtotime échoue, on vérifie
                    if ($timestamp !== false) {
                        $end = date('Y-m-d H:i:s', $timestamp + 1800); // +30 min

                        $result[] = [
                            'id'    => $row->entreeId,
                            'title' => $row->nature . ' x' . $row->quantite,
                            'start' => $start,
                            'end'   => $end,
                        ];
                    }
                }
            }

            return $result;
        }


        public function get_non_planifiees() {
                $this->db->where('heurePrevu IS NULL');
                $query = $this->db->get($this->table);
                $result = [];

                foreach ($query->result() as $row) {
                    $result[] = [
                        'id'    => $row->entreeId,
                        'title' => $row->nature . ' x' . $row->quantite
                    ];
                }

                return $result;
            }





    public function update_heure_prevu($id, $new_start) {
        return $this->db->where('entreeId', $id)
                        ->update($this->table, ['heurePrevu' => $new_start]);
    }


}


?>