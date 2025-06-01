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
            
                $data['reservation'] = $this->reservation_model->ReservationInfo($reservation); 
        
                $data['retours'] = $this->services_model->retourListing($reservation);
                $data['entrees'] = $this->services_model->entreeListing($reservation);
                $data['rapport'] = $this->services_model->retourListing($reservation);
                $this->global["pageTitle"] = "service pour l'evenement ".$reservation;
                $this->loadViews("service/home", $this->global, $data , null);
        }


        /**
         * This function used to load the first screen of the user
         */
        public function entree($reservation)
        {
                $data['retours'] = $this->services_model->retourListing($reservation);
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
                    // Récup retours déjà enregistrés pour cette résa (associés aux entrées)
                $data['rapport'] = $this->services_model->retourListing($reservation);
                $data['retours'] = $this->services_model->retourListing($reservation);
                $data['reservation'] = $this->reservation_model->ReservationInfo($reservation); 
                $data['entrees'] = $this->services_model->entreeListing($reservation); 
                $this->global["pageTitle"] = "Les entrées pour la soirée";
                $this->loadViews("service/sortie", $this->global, $data , null);
        }

                /**
         * This function used to load the first screen of the user
         */
        public function satisfaction($reservation)
        {
                $data['reservation'] = $this->reservation_model->ReservationInfo($reservation);
                $data['retours'] = $this->services_model->retourListing($reservation);
                $data['entrees'] = $this->services_model->entreeListing($reservation);
                $data['rapport'] = $this->services_model->retourListing($reservation);

                $this->global["pageTitle"] = "Rapport final de la réservation";
                $this->loadViews("service/satisfaction", $this->global, $data, null);
        }

             public function afficherFeedback($reservationId)
            {
                $data['reservation'] = $this->reservation_model->ReservationInfo($reservationId);
                $data['feedbacks'] = $this->services_model->getFeedbacks($reservationId);
                $this->global['pageTitle'] = "Rapport de Satisfaction";
                $this->loadViews("service/rapport", $this->global, $data, null);
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
                                            'note'            => $note,
                                            'createdBy'       => $this->vendorId,
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


         
         public function addRetours($reservationId)
            {
                $entreeIds = $this->input->post('entree_id');
                $quantitesRetour = $this->input->post('quantite_retour'); // ici tu peux renommer en quantite_retournee
                $notes = $this->input->post('note_retour');

                $createdBy = $this->vendorId; // ou $this->session->userdata('userId');
                $createdDTM = date('Y-m-d H:i:s');

                $dataToInsert = [];

                for ($i = 0; $i < count($entreeIds); $i++) {
                    if (isset($quantitesRetour[$i]) && trim($quantitesRetour[$i]) !== '') {
                        $dataToInsert[] = array(
                            'entreeId'         => $entreeIds[$i],
                            'quantiteRetournee'=> $quantitesRetour[$i],
                            'noteRetour'       => htmlspecialchars($notes[$i]),
                            'createdBy'        => $createdBy,
                            'createdDTM'       => $createdDTM
                        );
                    }
                }

                if (!empty($dataToInsert)) {
                    $this->services_model->insertMultipleRetours($dataToInsert);
                    $this->session->set_flashdata('success', 'Retours enregistrés avec succès.');
                } else {
                    $this->session->set_flashdata('error', 'Aucun retour valide à enregistrer.');
                }

                redirect('/Reservation/sortie/'.$reservationId); // adapte si besoin
            }

                
            public function saveFeedback($reservationId)
            {
                $ratingSalle = $this->input->post('rating_salle');
                $ratingService = $this->input->post('rating_service');
                $photoBase64 = $this->input->post('photo_base64');
                $createdBy = $this->session->userdata('userId') ?? 0;
                $createdDTM = date('Y-m-d H:i:s');
                $commentaire = $this->input->post('commentaire'); 
                $nom = $this->input->post('nom'); 


                // Nettoyage et validation simple
                $ratingSalle = intval($ratingSalle);
                $ratingService = intval($ratingService);

                // On veut garder uniquement la base64 sans le prefix "data:image/jpeg;base64,"
                $photoData = null;
                if ($photoBase64 && preg_match('/^data:image\/jpeg;base64,/', $photoBase64)) {
                    $photoData = substr($photoBase64, strpos($photoBase64, ',') + 1);
                }

                $dataToInsert = [
                    'reservationId'   => $reservationId,
                    'note_salle'      => $ratingSalle,
                    'note_service'    => $ratingService,
                    'photo_user'      => $photoData, // stocké en base64 (texte long)
                    'nom'             => $nom, 
                    'commentaire'     => $commentaire, 
                    'createdBy'       => $createdBy,
                    'createdDTM'      => $createdDTM
                ];

                $this->load->model('services_model');
                $result = $this->services_model->insertFeedback($dataToInsert);

                if ($result) {
                    $this->session->set_flashdata('success', 'Merci pour votre retour !');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de l’enregistrement.');
                }

                redirect('/Reservation/satisfaction/'.$reservationId);
            }


       

       
}
?>
