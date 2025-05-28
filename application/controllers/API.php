<?php
if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class API extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('services_model');
        $this->load->library('session');
        header('Content-Type: application/json'); // Toujours préciser JSON en sortie
    }

    public function update_entree()
    {
        // On check direct la méthode POST, sinon on bloque avec code 405
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Méthode non autorisée']);
            return;
        }

        $raw = file_get_contents("php://input");
        $data = json_decode($raw);

        if (!$data || !isset($data->id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant ou données invalides']);
            return;
        }

        $id = (int) $data->id;
        $quantite = isset($data->quantite) ?  $data->quantite : 0;
        $moment_service = isset($data->moment_service) ? $data->moment_service : '';

        $entree = $this->services_model->getById($id);
        if (!$entree) {
            http_response_code(404);
            echo json_encode(['error' => 'Entrée introuvable']);
            return;
        }

        $update = [];
        if ($quantite > 0) {
            $update['quantite'] = $entree['quantite'] + $quantite;
        }
        if ($moment_service) {
            $update['moment_service'] = $moment_service;
        }

        $user = $this->session->userdata('name') ?? 'inconnu';
        $update['note'] = $entree['note'] . "<br>------------------ ". date('d/m/Y H:i:s') . " MAJ par<b> $user </b> <br> ajout de $quantite pour $moment_service de l'event <br>" ;

        $success = $this->services_model->update($id, $update);

        if ($success) {
            http_response_code(200);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur de mise à jour']);
        }
    }
}
