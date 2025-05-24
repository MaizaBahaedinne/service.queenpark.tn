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


         public function update_entree() {
                // On s'assure que c'est bien une requête AJAX POST
                if ($this->input->method() !== 'post') {
                    return $this->output
                                ->set_status_header(405)
                                ->set_output(json_encode(['error' => 'Method not allowed']));
                }

                // Récupérer les données JSON brutes envoyées par fetch()
                $json = file_get_contents('php://input');
                $data = json_decode($json, true);

                // Validation simple
                if (!isset($data['id'], $data['quantite'], $data['moment_service'])) {
                    return $this->output
                                ->set_status_header(400)
                                ->set_output(json_encode(['error' => 'Données manquantes']));
                }

                $id = (int) $data['id'];
                $quantite = (int) $data['quantite'];
                $moment_service = $this->db->escape_str($data['moment_service']);

                // Prépare les données à mettre à jour
                $updateData = [
                    'quantite' => $quantite,
                    'moment_service' => $moment_service
                    
                ];

                // Effectue la mise à jour via le modèle
                $success = $this->Entree_model->update_entree($id, $updateData);

                if ($success) {
                    return $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode(['success' => true]));
                } else {
                    return $this->output
                                ->set_status_header(500)
                                ->set_output(json_encode(['error' => 'Erreur lors de la mise à jour']));
                }
            }
                


       
}
?>
