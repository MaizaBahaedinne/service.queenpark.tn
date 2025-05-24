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


        public function update_entree()
                {
                    // Vérifie que la requête est bien en POST
                    if ($this->request->getMethod() !== 'post') {
                        return $this->response->setStatusCode(405)->setJSON(['error' => 'Méthode non autorisée']);
                    }

                    // Récupère les données JSON envoyées depuis le JS
                    $data = $this->request->getJSON();

                    // Sécurisation & validation
                    if (!isset($data->id)) {
                        return $this->response->setStatusCode(400)->setJSON(['error' => 'ID manquant']);
                    }

                    $id = (int) $data->id;
                    $quantite = isset($data->quantite) ? (int) $data->quantite : 0;
                    $moment_service = isset($data->moment_service) ? trim($data->moment_service) : null;

                    // Prépare les champs à mettre à jour
                    $fields = [];

                    if ($quantite > 0) {
                        $fields['quantite'] = $quantite;
                    }

                    if (!empty($moment_service)) {
                        $fields['moment_service'] = $moment_service;
                    }

                    // Si aucun champ modifié, rien à faire
                    if (empty($fields)) {
                        return $this->response->setStatusCode(400)->setJSON(['error' => 'Aucune modification']);
                    }

                    // Ajoute un log de modification dans le champ "note"
                    $userName = $this->session->get('name') ?? 'Inconnu';
                    $now = date('d/m/Y H:i:s');

                    $noteLine = "🕒 $now - Modification par $userName<br>";
                    if (isset($fields['quantite'])) {
                        $noteLine .= "➕ Quantité modifiée à : {$fields['quantite']}<br>";
                    }
                    if (isset($fields['moment_service'])) {
                        $noteLine .= "🔄 Moment modifié à : {$fields['moment_service']}<br>";
                    }

                    // Récupération de la note existante
                    $model = new \App\Models\EntreeModel(); // Remplace par ton modèle réel
                    $entree = $model->find($id);
                    if (!$entree) {
                        return $this->response->setStatusCode(404)->setJSON(['error' => 'Entrée non trouvée']);
                    }

                    $fields['note'] = $noteLine . '<hr>' . $entree['note'];

                    // Mise à jour en base
                    $model->update($id, $fields);

                    return $this->response->setJSON(['success' => true, 'message' => 'Entrée mise à jour']);
                }



         
                


       
}
?>
