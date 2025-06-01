<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Reservation_model extends CI_Model
{
    
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function ReservationAffecationListing($userId = null )
    {
        $this->db->select('BaseTbl.reservationId , BaseTbl.salleId , BaseTbl.titre , BaseTbl.type , BaseTbl.prix ,  BaseTbl.dateDebut , BaseTbl.heureDebut , BaseTbl.dateFin , BaseTbl.heureFin , BaseTbl.cuisine , BaseTbl.tableCM  , BaseTbl.nbPlace , BaseTbl.noteAdmin , BaseTbl.statut , Client.name clientName , Client.mobile , Salles.nom salle');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_service_affectation as affecation', 'affecation.reservationId = BaseTbl.reservationId','left');
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        
        
        $this->db->where('BaseTbl.dateFin >=  SUBDATE(NOW(),2) ');
        

        $this->db->where('affecation.userId  =',$userId );
        $this->db->where('BaseTbl.statut in (0,1) ');

    
         $this->db->order_by('BaseTbl.dateFin ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


/**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function ReservationListing()
    {
        $this->db->select('BaseTbl.reservationId , BaseTbl.salleId , BaseTbl.titre , BaseTbl.type , BaseTbl.prix ,  BaseTbl.dateDebut , BaseTbl.heureDebut , BaseTbl.dateFin , BaseTbl.heureFin , BaseTbl.cuisine , BaseTbl.tableCM  , BaseTbl.nbPlace , BaseTbl.noteAdmin , BaseTbl.statut , Client.name clientName , Client.mobile , Salles.nom salle');
        $this->db->from('tbl_reservation as BaseTbl');
       
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        
        
        $this->db->where('BaseTbl.dateFin >=  SUBDATE(NOW(),1) ');
        
        $this->db->where('BaseTbl.statut in (0,1) ');
        $this->db->limit('30');
         $this->db->order_by('BaseTbl.dateFin ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

   

   


 
     /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function ReservationInfo($resId)
    {
        $this->db->select('BaseTbl.reservationId, BaseTbl.salleId  , BaseTbl.titre , BaseTbl.type , BaseTbl.prix ,  BaseTbl.dateDebut  , DATE_ADD(BaseTbl.dateDebut , INTERVAL -30 DAY) delai  , BaseTbl.heureDebut , BaseTbl.dateFin , BaseTbl.heureFin , BaseTbl.cuisine , BaseTbl.tableCM ,  BaseTbl.troupe , BaseTbl.photographe , BaseTbl.voiture ,BaseTbl.nbPlace , BaseTbl.noteAdmin , BaseTbl.statut , Client.userId clientId , Client.dateCin , Client.name clientName ,  Client.cin , Client.mobile , Salles.salleID , Salles.nom salle ,  BaseTbl.clientId,Client.mobile ,Client.mobile2');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        $this->db->where('BaseTbl.reservationId =',$resId );

        $query = $this->db->get();
        
        return $query->row();
    }




        /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editReservation($reservationInfo, $reservationId , $userChange = null  )
    {

        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->where('BaseTbl.reservationId =',$reservationId );
        $query = $this->db->get();
        $copie = $query->row();
        print_r($copie) ; 
        $copie->createdBy = $userChange ; 
        $this->db->trans_start();
        
        $this->db->insert('tbl_reservation_backup', $copie);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        echo $insert_id;

        $this->db->where('reservationId', $reservationId);
        $this->db->update('tbl_reservation', $reservationInfo);
        
        return TRUE;
    }

   

   


}

  