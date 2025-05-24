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
    

    
    
    /**
     * This function is used to update the booking information
     * @param array $bookingInfo : This is booking updated information
     * @param number $bookingId : This is booking id
     */
    function editBooking($bookingInfo, $bookingId)
    {
        $this->db->where('bookingId', $bookingId);
        $this->db->update('tbl_booking', $bookingInfo);
        
        return TRUE;
    }


    public function getById($id) {
        return $this->db->get_where('tbl_services_entrees', ['id' => $id])->row_array();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('tbl_services_entrees', $data);
    }



}