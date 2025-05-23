<?php
if (!defined("BASEPATH")) {
        exit("No direct script access allowed");
}
require APPPATH . "/libraries/BaseController.php";
/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Reservation extends BaseController
{
        /**
         * This is default constructor of the class
         */
        public function __construct()
        {
                parent::__construct();
                $this->load->model("reservation_model");
   
                $this->isLoggedIn();
        }
       


        /**
         * This function used to load the first screen of the user
         */
        public function service($reservation)
        {
                $this->data['reservationId'] = $reservation ;
                $this->global["pageTitle"] = "service pour l'evenement ".$reservation;
                $this->loadViews("service/home", $this->global, $data , null);
        }


                /**
         * This function used to load the first screen of the user
         */
        public function entree($reservation)
        {

                $this->global["pageTitle"] = "Les entrées pour la soirée";
                $this->loadViews("service/entre", $this->global, null , null);
        }


       
}
?>
