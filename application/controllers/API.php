<?php
if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}
require APPPATH . "/libraries/BaseController.php";
/**
 * Class : API
 * Control all API related operations
 */
class API extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('services_model');
        $this->load->library('session'); // Si tu utilises session
        header('Content-Type: application/json; charset=utf-8'); // Toujours répondre JSON
    }

    public function update_entree()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['error' => 'Méthode non autorisée']);
                exit;
            }

            $raw = file_get_contents("php://input");
            $data = json_decode($raw);

            if (!isset($data->id)) {
                http_response_code(400);
                echo json_encode(['error' => 'ID manquant']);
                exit;
            }

            $id = (int) $data->id;
            $quantite = isset($data->quantite) ? (int) $data->quantite : 0;
            $moment_service = isset($data->moment_service) ? $data->moment_service : '';

            $entree = $this->services_model->getById($id);
            if (!$entree) {
                http_response_code(404);
                echo json_encode(['error' => 'Entrée introuvable']);
                exit;
            }

            $update = [];
            if ($quantite > 0) {
                $update['quantite'] = $quantite;
            }
            if ($moment_service) {
                $update['moment_service'] = $moment_service;
            }

            $user = $this->session->userdata('name') ?? 'inconnu';
            $update['note'] =  $entree['note'] . "<br>------------------ ". date('d/m/Y H:i:s') ." MAJ par <b> $user </b> " 
             "<br> ajout de ".$quantite. " vers ".$moment_service . "l'évenementÒ"  ;

            $this->services_model->update($id, $update);

            echo json_encode(['success' => true]);
            exit;

        } catch (Exception $e) {
            log_message('error', 'Erreur update_entree: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Erreur serveur']);
            exit;
        }
    }
}
?>
