<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Booking_model (Booking Model)
 * Booking model class to get to handle booking related data 
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 18 Jun 2022
 */
class Services_model extends CI_Model
{

    /**
     * This function is used to get the booking listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function entreeListing($resId)
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_services_entrees as BaseTbl');
       	
        $this->db->where('BaseTbl.reservationId', $resId);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to add new booking to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewEntre($bookingInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_services_entrees', $bookingInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    public function insertMultipleEntrees($data)
		{
		    return $this->db->insert_batch('tbl_services_entrees', $data);
		}
    

    public function retourListing($reservationId)
    {
        $this->db->select('r.*, e.nature, e.quantite');
        $this->db->from('tbl_services_retours r');
        $this->db->join('tbl_services_entrees e', 'e.entreeId = r.entreeId', 'left');
        $this->db->where('e.reservationId', $reservationId);
        $this->db->order_by('r.createdDTM', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }
    


    public function getById($id) {
        return $this->db->get_where('tbl_services_entrees', ['entreeId' => $id])->row_array();
    }

    public function update($id, $data) {
        return $this->db->where('entreeId', $id)->update('tbl_services_entrees', $data);
    }


    public function insertMultipleRetours($data)
        {
            return $this->db->insert_batch('tbl_services_retours', $data);
        }




}