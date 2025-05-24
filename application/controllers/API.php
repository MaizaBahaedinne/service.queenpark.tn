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
class API extends CI_Controller
{
     public function __construct()
    {
        parent::__construct();
        $this->load->model('services_model');
        $this->load->library('session'); // Si tu utilises session
    }

    public function update_entree()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_error('Méthode non autorisée', 405);
        }

        $raw = file_get_contents("php://input");
        $data = json_decode($raw);

        if (!isset($data->id)) {
            show_error('ID manquant', 400);
        }

        $id = (int) $data->id;
        $quantite = isset($data->quantite) ? (int) $data->quantite : 0;
        $moment_service = isset($data->moment_service) ? $data->moment_service : '';

        $update = [];

        if ($quantite > 0) {
            $update['quantite'] = $quantite;
        }

        if ($moment_service) {
            $update['moment_service'] = $moment_service;
        }

        $entree = $this->Entree_model->getById($id);

        if (!$entree) {
            echo json_encode(['error' => 'Entrée introuvable']);
            return;
        }

        $user = $this->session->userdata('name') ?? 'inconnu';
        $update['note'] = "MAJ par $user le ".date('d/m/Y H:i:s')."<br>".$entree['note'];

        $this->Entree_model->update($id, $update);

        echo json_encode(['success' => true]);
    }  
}
?>
