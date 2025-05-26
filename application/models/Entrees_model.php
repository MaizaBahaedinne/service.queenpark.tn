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
            $result[] = [
                'id'    => $row->entreeId,
                'title' => $row->nature . ' x' . $row->quantite,
                'start' => $row->heurePrevu,
                'end'   => date('Y-m-d H:i:s', strtotime($row->heurePrevu) + 1800),
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