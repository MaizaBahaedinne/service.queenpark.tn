<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Services extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('entrees_model');
    }

    public function get_entrees_calander() {
        $events = $this->entrees_model->get_all();
        echo json_encode($events);
    }

    public function update_entree_calander() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id'], $data['start'])) {
            $updated = $this->entrees_model->update_heure_prevu($data['id'], $data['start']);
            echo json_encode(['success' => $updated]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Paramètres manquants.']);
        }
    }

    public function get_entrees_non_planifiees($resId) {
    $events = $this->entrees_model->get_non_planifiees($resId);
    echo json_encode($events);
}


public function delete_entree_calander() {
  $data = json_decode(file_get_contents('php://input'), true);
  $id = $data['id'] ?? null;
  
  if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID manquant']);
    return;
  }
  
  // Mettre heurePrevu à NULL dans la BDD pour cet id
  $this->db->set('heurePrevu', null);
  $this->db->where('id', $id);
  $updated = $this->db->update('entrees');
  
  echo json_encode(['success' => $updated]);
}



}


?>