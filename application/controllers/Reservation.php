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
                $this->load->model("services_model");
   
                $this->isLoggedIn();
        }
       


        /**
         * This function used to load the first screen of the user
         */
        public function service($reservation)
        {
                $data['reservationId'] = $reservation ;
                $this->global["pageTitle"] = "service pour l'evenement ".$reservation;
                $this->loadViews("service/home", $this->global, $data , null);
        }


        /**
         * This function used to load the first screen of the user
         */
        public function entree($reservation)
        {
                $data['reservation'] = $this->reservation_model->ReservationInfo($reservation); 
                $data['entrees'] = $this->services_model->entreeListing($reservation); 
                $this->global["pageTitle"] = "Les entrées pour la soirée";
                $this->loadViews("service/entre", $this->global, $data , null);
        }


                /**
         * This function used to load the first screen of the user
         */
        public function sortie($reservation)
        {
                $data['reservation'] = $this->reservation_model->ReservationInfo($reservation); 
                $data['entrees'] = $this->services_model->entreeListing($reservation); 
                $this->global["pageTitle"] = "Les entrées pour la soirée";
                $this->loadViews("service/entre", $this->global, $data , null);
        }


        public function addEntrees($reservationId)
                {
                            $reservationId = $reservationId ;
                            $quantites = $this->input->post('quantite');
                            $natures = $this->input->post('nature');
                            $moments = $this->input->post('moment_service');
                            $notes = " ------------------  ".date('d/m/Y H:i:s')." - Nouveau entrée par ".$this->name." ------------------  <br>" ;

                            $createdBy = $this->vendorId; // ou $this->session->userdata('userId');
                            $createdDTM = date('Y-m-d H:i:s');

                            
                            $dataToInsert = [];

                            for ($i = 0; $i < count($quantites); $i++) {
                                    if (trim($quantites[$i]) !== '') {
                                        $note = "------------------  " . date('d/m/Y H:i:s') . "  Nouveau entrée par " . $this->name . " ------------------ <br>" .
                                                "quantite : " . $quantites[$i] . "<br>" .
                                                "nature : " . $natures[$i] . "<br>";

                                        $dataToInsert[] = array(
                                            'reservationId'   => $reservationId,
                                            'quantite'        => $quantites[$i],
                                            'nature'          => $natures[$i],
                                            'moment_service'  => $moments[$i],
                                            'note'            => $note
                                        );
                                    }
                                }
                            

                            if (!empty($dataToInsert)) {
                                $result = $this->services_model->insertMultipleEntrees($dataToInsert);

                                if ($result) {
                                    $this->session->set_flashdata('success', 'Entrées ajoutées avec succès');
                                } else {
                                    $this->session->set_flashdata('error', 'Erreur lors de l’enregistrement');
                                }
                            } else {
                                $this->session->set_flashdata('error', 'Aucune entrée valide');
                            }
                            redirect('/Reservation/entree/'.$reservationId); // redirection vers une liste ou autre vue
                        
                    }


         
                


       
}
?>
