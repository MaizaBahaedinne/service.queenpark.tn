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
class API extends BaseController
{
        /**
         * This is default constructor of the class
         */
        public function __construct()
        {
                parent::__construct();
                $this->load->model("reservation_model");
                $this->load->model("services_model");
   
               
        }
       

       public function update_entree()
                {
                    // Vérifie que la requête est bien en POST
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        show_error('Méthode non autorisée', 405);
                        return;
                    }

                    // Récupère le JSON brut depuis le body
                    $rawInput = file_get_contents("php://input");
                    $data = json_decode($rawInput);

                    if (!isset($data->id)) {
                        show_error('ID manquant', 400);
                        return;
                    }

                    $id = (int) $data->id;
                    $quantite = isset($data->quantite) ? (int) $data->quantite : 0;
                    $moment_service = isset($data->moment_service) ? trim($data->moment_service) : null;

                    $fields = [];

                    if ($quantite > 0) {
                        $fields['quantite'] = $quantite;
                    }

                    if (!empty($moment_service)) {
                        $fields['moment_service'] = $moment_service;
                    }

                    if (empty($fields)) {
                        echo json_encode(['error' => 'Aucune modification']);
                        return;
                    }

                    // Chargement du modèle (à adapter)
                    $this->load->model('Entree_model'); // Change le nom si besoin
                    $entree = $this->Entree_model->getById($id);

                    if (!$entree) {
                        echo json_encode(['error' => 'Entrée non trouvée']);
                        return;
                    }

                    $userName = $this->session->userdata('name') ?? 'Inconnu';
                    $now = date('d/m/Y H:i:s');

                    $noteLine = "🕒 $now - Modification par $userName<br>";
                    if (isset($fields['quantite'])) {
                        $noteLine .= "➕ Quantité modifiée à : {$fields['quantite']}<br>";
                    }
                    if (isset($fields['moment_service'])) {
                        $noteLine .= "🔄 Moment modifié à : {$fields['moment_service']}<br>";
                    }

                    $fields['note'] = $noteLine . '<hr>' . $entree['note'];

                    $this->Entree_model->update($id, $fields);

                    echo json_encode(['success' => true, 'message' => 'Entrée mise à jour']);
                }




         
                


       
}
?>
