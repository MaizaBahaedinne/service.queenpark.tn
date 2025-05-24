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
class API extends REST_Controller
{
    

     public function __construct()
    {
        parent::__construct();
        $this->load->model('services_model');
        $this->load->library('session'); // Si tu utilises session
    }

    public function update_entree()
        {
            try {
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    return $this->respond(['error' => 'Méthode non autorisée'], 405);
                }

                $raw = file_get_contents("php://input");
                $data = json_decode($raw);

                if (!isset($data->id)) {
                    return $this->respond(['error' => 'ID manquant'], 400);
                }

                $id = (int) $data->id;
                $quantite = isset($data->quantite) ? (int) $data->quantite : 0;
                $moment_service = isset($data->moment_service) ? $data->moment_service : '';

                $entree = $this->services_model->getById($id);
                if (!$entree) {
                    return $this->respond(['error' => 'Entrée introuvable'], 404);
                }

                $update = [];
                if ($quantite > 0) {
                    $update['quantite'] = $quantite;
                }
                if ($moment_service) {
                    $update['moment_service'] = $moment_service;
                }

                $user = $this->session->userdata('name') ?? 'inconnu';
                $update['note'] = "MAJ par $user le ".date('d/m/Y H:i:s')."<br>".htmlspecialchars($entree['note'], ENT_QUOTES, 'UTF-8');

                $this->services_model->update($id, $update);

                return $this->respond(['success' => true]);
            } catch (Exception $e) {
                log_message('error', 'Erreur update_entree: '.$e->getMessage());
                return $this->respond(['error' => 'Erreur serveur'], 500);
            }
        }

}
?>
