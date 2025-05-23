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
    function ReservationListing($date = null)
    {
        $this->db->select('BaseTbl.reservationId , BaseTbl.salleId , BaseTbl.titre , BaseTbl.type , BaseTbl.prix ,  BaseTbl.dateDebut , BaseTbl.heureDebut , BaseTbl.dateFin , BaseTbl.heureFin , BaseTbl.cuisine , BaseTbl.tableCM  , BaseTbl.nbPlace , BaseTbl.noteAdmin , BaseTbl.statut , Client.name clientName , Client.mobile , Salles.nom salle');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        
        if($date == null){
      // 

        $this->db->where('BaseTbl.dateFin >=  SUBDATE(NOW(),2) ');

        }

       

        if( $date != null ){
         $this->db->where("BaseTbl.dateFin >=   '".$date."'" );
        
        }

       
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
    function ReservationListing($troupe = 0 , $photographe = 0 , $date = null , $clientId = null )
    {
        $this->db->select('BaseTbl.reservationId , BaseTbl.salleId , BaseTbl.titre , BaseTbl.type , BaseTbl.prix ,  BaseTbl.dateDebut , BaseTbl.heureDebut , BaseTbl.dateFin , BaseTbl.heureFin , BaseTbl.cuisine , BaseTbl.tableCM , BaseTbl.voiture , BaseTbl.troupe , BaseTbl.photographe , BaseTbl.gateau   , BaseTbl.nbPlace , BaseTbl.noteAdmin , BaseTbl.statut , Client.name clientName , Client.mobile , Salles.nom salle');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        
        if($date == null){
      // 

        $this->db->where('BaseTbl.dateFin >=  SUBDATE(NOW(),2) ');

        }

        if( $troupe != 0 ){
        $this->db->where('BaseTbl.troupe = ',1);
        }

        if( $photographe != 0 ){
        $this->db->where('BaseTbl.photographe = ',1);
        }


        if( $date != null ){
         $this->db->where("BaseTbl.dateFin >=   '".$date."'" );
        
        }

        if( $clientId != null ){
            $this->db->where('BaseTbl.statut in (0,1,3) ');
         $this->db->where('BaseTbl.clientId = ', $clientId );


        }

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
    function ReservationListingOld(  $dateF = null )
    {
        $this->db->select('BaseTbl.reservationId , BaseTbl.titre , BaseTbl.type , BaseTbl.prix ,  BaseTbl.dateDebut , BaseTbl.heureDebut , BaseTbl.dateFin , BaseTbl.heureFin , BaseTbl.cuisine , BaseTbl.tableCM , BaseTbl.voiture , BaseTbl.troupe , BaseTbl.photographe , BaseTbl.gateau   , BaseTbl.nbPlace , BaseTbl.noteAdmin , BaseTbl.statut , Client.name clientName , Client.mobile , Salles.nom salle');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        
        if ($dateF == null )  {      
        $this->db->where('BaseTbl.dateFin <= NOW() ');
        $this->db->where('Year(BaseTbl.dateFin) >= Year(NOW())-1 ');
         }
         else {
            $this->db->where('Year(BaseTbl.dateFin) = ',$dateF );
          }


        $this->db->where('BaseTbl.statut in (0,1,3) ');
    
         $this->db->order_by('BaseTbl.dateFin DESC');
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
    function ReservationListingByClient($clientId = null )
    {
        $this->db->select('BaseTbl.reservationId , BaseTbl.dateDebut , BaseTbl.statut , Salles.nom salle');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');

         $this->db->where('BaseTbl.clientId = ', $clientId );

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
    function ClassementSalle($year = null )
    {
        $this->db->select('count(BaseTbl.reservationId) countRes ,  Salles.nom packname');
        $this->db->from('tbl_reservation as BaseTbl');
        
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        

        $this->db->where('YEAR(BaseTbl.dateFin)  = ', $year);
        $this->db->where('BaseTbl.statut in (0,1) ');
        $this->db->group_by('packname');
        $this->db->order_by('countRes DESC');
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
    function ReservationBackupListing($resId  )
    {

        $this->db->select('BaseTbl.backupId, BaseTbl.reservationId , BaseTbl.titre , BaseTbl.type , BaseTbl.prix ,  BaseTbl.dateDebut , BaseTbl.heureDebut , BaseTbl.dateFin , BaseTbl.heureFin , BaseTbl.cuisine , BaseTbl.tableCM , BaseTbl.voiture , BaseTbl.troupe , BaseTbl.photographe , BaseTbl.gateau   , BaseTbl.nbPlace , BaseTbl.noteAdmin , BaseTbl.statut , Client.name clientName , Client.mobile , Salles.nom salle , Locataire.avatar , Locataire.name  recuPar , BaseTbl.editDTM ');
        $this->db->from('tbl_reservation_backup as BaseTbl');
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.createdBy','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');

        
        
    
        $this->db->where('BaseTbl.reservationID= ', $resId );
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
    function ReservationCalenderStat()
    {
        $this->db->select('*');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->where('BaseTbl.statut IN (0 ) ');
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
    function ReservationYearStat($status)
    {
        $this->db->select('COUNT(reservationId) countRes , Year(BaseTbl.dateFin) yearDate ');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->where('BaseTbl.statut IN ('.$status.') ');
        $this->db->group_by('yearDate') ;
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
    function ReservationYearTypesStat($status)
    {
        $this->db->select('COUNT(reservationId) countTypes , BaseTbl.type , , Year(BaseTbl.dateFin) yearDate ');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->where('BaseTbl.statut IN ('.$status.')  and  Year(BaseTbl.dateFin) = Year(NOW()) ');
        $this->db->group_by('BaseTbl.type') ;
        $this->db->group_by('yearDate') ;
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
    function ReservationCalenderStatMounth()
    {
        $this->db->select('');
        $this->db->from('statmounth as BaseTbl');
 
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
    function ReservationCalenderStatMounth1()
    {
        $this->db->select('');
        $this->db->from('statmount1 as BaseTbl');
 
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
    function ReservationCalenderStatYear()
    {
        $this->db->select('sum(COUNT) as COUNT , BaseTbl.YEAR as YEAR');
        $this->db->from('statmounth as BaseTbl');

        $this->db->group_by('YEAR');
        
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
    function ReservationCalenderStatSalle()
    {
        $this->db->select('count(*) as COUNT , BaseTbl.salleId , Salles.nom ');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        $this->db->group_by('BaseTbl.salleId');
        $this->db->where('BaseTbl.statut IN (1,0) ');
        $this->db->where('YEAR(BaseTbl.dateFin) >= YEAR(NOW()) ');
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
    function ReservationCalenderStatEmploye()
    {
        $this->db->select('count(userId) as COUNT , BaseTbl.salleId , Locataire.name , Locataire.avatar ');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.locataireId','left');
        
        $this->db->where('BaseTbl.statut IN (0) ');
        
        $this->db->group_by('BaseTbl.locataireId');
        $this->db->order_by('count(userId) DESC');

        
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
    function ReservationCalender()
    {
        $this->db->select('   BaseTbl.dateDebut , BaseTbl.heureDebut  ');
        $this->db->from('tbl_reservation as BaseTbl');

    

        $this->db->where('BaseTbl.statut IN (0,1) ');

         
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
    function ReservationCalender1($salleId)
    {
        $this->db->select('BaseTbl.reservationId , BaseTbl.salleId , BaseTbl.titre , BaseTbl.type , BaseTbl.prix ,  BaseTbl.dateDebut , BaseTbl.heureDebut , BaseTbl.dateFin , BaseTbl.heureFin , BaseTbl.cuisine , BaseTbl.tableCM , BaseTbl.nbPlace , BaseTbl.noteAdmin , BaseTbl.statut , Client.name clientName , Client.mobile , Salles.nom salle');
        $this->db->from('tbl_reservation as BaseTbl');
        $this->db->join('tbl_users as Client', 'Client.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_users as Locataire', 'Locataire.userId = BaseTbl.clientId','left');
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId ','left');
        $this->db->where('BaseTbl.salleId =',$salleId);
        $this->db->where('BaseTbl.statut IN (0,1) ');
        $this->db->where('BaseTbl.dateDebut >= NOW() ');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


    

    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewReservation($reservationInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_reservation', $reservationInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

        
    function checkreservation($dateDebut,$datefin,$heureDebut,$heureFin,$salleID){
        $this->db->select("dateDebut , dateFin");
        $this->db->from("tbl_reservation");
        $this->db->join('tbl_salle as Salles', 'Salles.salleID = BaseTbl.salleId','left');
        $this->db->where("dateDebut BETWEEN ".$dateDebut." AND ".$dateFin);
        $this->db->where("dateFin BETWEEN ".$dateDebut." AND ".$dateFin);
        $this->db->where("heureDebut BETWEEN ".$heureDebut." AND ".$heureFin);
        $this->db->where("heureFin BETWEEN ".$heureDebut." AND ".$heureFin);   
        $this->db->where("tbl_reservation.statut = 0 or tbl_reservation.statut = 1 ",'');
        $this->db->where("tbl_reservation.statut = 0 or tbl_reservation.statut = 1 ",'');
        $this->db->where("Salles.salleID = ",$salleID );


        
        $query = $this->db->get();

        return $query->result();

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

  