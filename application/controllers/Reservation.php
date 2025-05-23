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
                $this->load->model("user_model");
                $this->load->model("client_model");
                $this->load->model("reservation_model");
                $this->load->model("salle_model");
                $this->load->model("paiement_model");
                $this->load->model("contrat_model");
                $this->load->model("voiture_model");
                $this->load->model("photographe_model");
                $this->load->model("prestation_model");
                $this->load->model("troupe_model");
                $this->load->model("satisfaction_model");
                $this->load->model("Sms_model");
                $this->isLoggedIn();
        }
        /**
         * This function used to load the first screen of the user
         */
        public function index()
        {
                
                $data["userRecords"] = $this->reservation_model->ReservationListing();
                     foreach ($data["userRecords"]  as $rerva) {
        
                         $rerva->prestation = $this->prestation_model->ReservationListing($rerva->reservationId) ; 
                       }   
                $this->global["pageTitle"] = "Reservation des salles";
                $this->loadViews("reservation/list", $this->global, $data, null);
        }


        /**
         * This function used to load the first screen of the user
         */
        public function Calender()
        {
                
                $data["userRecords"] = $this->reservation_model->ReservationListing();
                     foreach ($data["userRecords"]  as $rerva) {
        
                         $rerva->prestation = $this->prestation_model->ReservationListing($rerva->reservationId) ; 
                       }   
                $this->global["pageTitle"] = "Reservation des salles";
                $this->global["calenderOK"] = true ;
                $this->global["calenderType"] = 'dayGridMonth' ;
                $this->loadViews("reservation/calender", $this->global, $data, null);
        }


        /**
         * This function used to load the first screen of the user
         */
        public function ReservationOld($dateD = null )
        {
                if ($dateD == null) {
                        $dateD = date('Y');
                    }
                $data["userRecords"] = $this->reservation_model->ReservationListingOld($dateD);
                     foreach ($data["userRecords"]  as $rerva) {
        
                         $rerva->prestation = $this->prestation_model->ReservationListing($rerva->reservationId) ; 
                       }   
                $this->global["pageTitle"] = "reservations des salles de ".$dateD ;
                $this->loadViews("reservation/list", $this->global, $data, null);
        }

        public function addNew()
        {
                $data["salleRecords"] = $this->salle_model->SalleListing();
                $this->global["pageTitle"] = "Ajouter reservation";
                $this->loadViews("reservation/new", $this->global, $data, null);
        }
        /**
         * This function is used to add new user to the system
         */
        function addNewReservation()
        {
                $clientId = $this->input->post("clientId");
                $nom = $this->input->post("nom");
                $prenom = $this->input->post("prenom");
                $CIN = $this->input->post("CIN");
                $dateCin = $this->input->post("dateCin");
                $n = $this->input->post("N");
                $rue = $this->input->post("rue");
                $ville = $this->input->post("ville");
                $codePostal = $this->input->post("codePostal");
                $email = $this->input->post("email");
                $mobile = $this->input->post("mobile");
                $mobile2 = $this->input->post("mobile2");
                $birthday = $this->input->post("birth");
                $sexe = $this->input->post("sexe");
                $source = $this->input->post("source");
                $userInfo = [
                        "email" => $email,
                        "password" => getHashedPassword($CIN),
                        "roleId" => 4,
                        "name" => $prenom . " " . $nom,
                        "cin" => $CIN,
                        "dateCin" => $dateCin,
                        "mobile" => $mobile,
                        "mobile2" => $mobile2,
                        "createdBy" => $this->vendorId,
                        "createdDtm" => date("Y-m-d H:i:s"),
                        "n " => $n,
                        "rue" => $rue,
                        "codePostal" => $codePostal,
                        "ville" => $ville,
                        "type" => "personne",
                        "nom" => $nom,
                        "prenom" => $prenom,
                        "Sexe" => $sexe,
                        "birthday" => $birthday,
                        "source" => $source,
                ];
                if ($clientId == null) {
                        $clientId = $this->client_model->addNewClient($userInfo);
                        var_dump($clientId);
                } else {
                        $this->client_model->editClient($userInfo, $clientId);
                }
                $dateDebut = $this->input->post("dateDebut");
                $heureDebut = $this->input->post("heureDebut");
                $dateFin = $this->input->post("dateDebut");
                $heureFin = $this->input->post("heureFin");
                $type = $this->input->post("type");
                $salle = $this->input->post("salle");
                $nbPlace = $this->input->post("nbPlace");
                $prix = $this->input->post("prix");
                $titre = $this->input->post("titre");
                $noteAdmin = $this->input->post("noteAdmin");
                $cuisine = $this->input->post("cuisine");
                $tableCM = $this->input->post("tableCM");
                $reservationInfo = [
                        "dateDebut" => $dateDebut,
                        "heureDebut" => $heureDebut,
                        "dateFin" => $dateFin,
                        "heureFin" => $heureFin,
                        "type" => $type,
                        "salleId" => $salle,
                        "nbPlace" => $nbPlace,
                        "prix" => $prix,
                        "titre" => $titre,
                        "noteAdmin" => $noteAdmin,
                        "statut" => 1,
                        "cuisine" => $cuisine,
                        "tableCM" => $tableCM,
                        "locataireId" => $this->vendorId,
                        "createdDTM" => date("Y-m-d H:i:s"),
                        "clientId" => $clientId,
                ];
                $result = $this->reservation_model->addNewReservation($reservationInfo);
                if ($result > 0) {
                        $this->session->set_flashdata("success", "Reservation mise à jour avec succées ");
                        redirect("Reservation/view/" . $result);
                } else {
                        $this->session->set_flashdata("error", "Problème de mise à jours");
                        redirect("Reservation/edit/" . $result);
                }
        }
        /**
         * This function is used to add new user to the system
         */
        function editReservation($resId)
        {
                $dateDebut = $this->input->post("dateDebut");
                $heureDebut = $this->input->post("heureDebut");
                $dateFin = $this->input->post("dateDebut");
                $heureFin = $this->input->post("heureFin");
                $type = $this->input->post("type");
                $salle = $this->input->post("salle");
                $nbPlace = $this->input->post("nbPlace");
                $prix = $this->input->post("prix");
                $titre = $this->input->post("titre");
                $noteAdmin = $this->input->post("noteAdmin");
                $cuisine = $this->input->post("cuisine");
                $tableCM = $this->input->post("tableCM");
                $troupe = $this->input->post("troupe");
                $photographe = $this->input->post("photographe");
                $reservationInfo = [
                        "dateDebut" => $dateDebut,
                        "heureDebut" => $heureDebut,
                        "dateFin" => $dateFin,
                        "heureFin" => $heureFin,
                        "type" => $type,
                        "salleId" => $salle,
                        "nbPlace" => $nbPlace,
                        "prix" => $prix,
                        "titre" => $titre,
                        "noteAdmin" => $noteAdmin,
                        "cuisine" => $cuisine,
                        "tableCM" => $tableCM,
                        
                ];

                $result = $this->reservation_model->
                       editReservation($reservationInfo,$resId, $this->vendorId );
                if ($result) {
                        $this->session->set_flashdata("success", "Reservation mise à jour avec succées ");
                        redirect("Reservation/view/" . $resId);
                } else {
                        $this->session->set_flashdata("error", "Problème de mise à jours");
                        redirect("Reservation/edit/" . $resId);
                }
        }
        function deleteReservation($resId)
        {
                $reservationInfo = ["statut" => 3];
                $result = $this->reservation_model->editReservation($reservationInfo, $resId, $this->vendorId);
                if ($result) {
                        $this->session->set_flashdata("success", "Reservation mise à jour avec succées ");
                        redirect("Reservation/view/" . $resId);
                } else {
                        $this->session->set_flashdata("error", "Problème de mise à jours");
                        redirect("Reservation/view/" . $resId);
                }
        }

                /**
         * This function is used to add new user to the system
         */
        function DateChange($resId)
        {       $data["projectInfo"] = $this->reservation_model->ReservationInfo($resId);
                $dateDebut = $this->input->post("dateDebut");
                $heureDebut = $this->input->post("heureDebut");
                $dateFin = $this->input->post("dateDebut");
                $heureFin = $this->input->post("heureFin");
                $reservationInfo = [
                        "dateDebut" => $dateDebut,
                        "heureDebut" => $heureDebut,
                        "dateFin" => $dateFin,
                        "heureFin" => $heureFin,
                        "noteAdmin" => "Changement de date de ".$data["projectInfo"]->dateDebut." vers ".$dateDebut,                    
                ];

                $result = $this->reservation_model->
                       editReservation($reservationInfo,$resId, $this->vendorId );
                if ($result) {
                        $this->session->set_flashdata("success", "Reservation mise à jour avec succées ");
                        redirect("Reservation/view/" . $resId);
                } else {
                        $this->session->set_flashdata("error", "Problème de mise à jours");
                        redirect("Reservation/edit/" . $resId);
                }
        }

        /**
         * This function is used to load the user list
         */
        function view($resId)
        {
                $data["projectInfo"] = $this->reservation_model->ReservationInfo($resId);
                $data["satisfaction"] = $this->satisfaction_model->ReservationInfo($resId);
                $data["clientInfo"] = $this->user_model->getUserInfo($data["projectInfo"]->clientId);
                $data["contratInfo"] = $this->contrat_model->contratInfo($resId);
                $data["paiementInfo"] = $this->paiement_model->paiementListingbyReservation($resId);
                $data["totalPaiement"] = $this->paiement_model->getTotal($resId);
                $data["Backups"] = $this->reservation_model->ReservationBackupListing($resId);
                $data["userID"] = $this->vendorId;
                $data["voiture"] = $this->voiture_model->ReservationInfo($data["projectInfo"]->voiture);
                $data["photographe"] = $this->photographe_model->ReservationInfo($data["projectInfo"]->photographe);
                $data["troupe"] = $this->troupe_model->ReservationInfo($data["projectInfo"]->troupe);
                $data["prestation"] = $this->prestation_model->ReservationListing($resId);
                $this->global["pageTitle"] = "Reservation de salle ".$resId;
                $this->loadViews("reservation/details", $this->global, $data, null);
        }
        /**
         * This function is used to load the user list
         */
        function recuP($resId)
        {
                $data["projectInfo"] = $this->reservation_model->ReservationInfo($resId);
                $data["contratInfo"] = $this->contrat_model->contratInfo($resId);
                $data["paiementInfo"] = $this->paiement_model->paiementListingbyReservation($resId);
                $data["totalPaiement"] = $this->paiement_model->getTotal($resId);
                $this->global["pageTitle"] = "Recu de reservation ".$resId;
                $this->loadViews("paiement/recu", $this->global, $data, null);
        }
        /**
         * This function is used to load the user list
         */
        function edit($resId)
        {
                $data["salleRecords"] = $this->salle_model->SalleListing();
                $data["projectInfo"] = $this->reservation_model->ReservationInfo($resId);
                $data["contratInfo"] = $this->contrat_model->contratInfo($resId);
                $data["paiementInfo"] = $this->paiement_model->paiementListingbyReservation($resId);
                $data["totalPaiement"] = $this->paiement_model->getTotal($resId);
                $this->global["pageTitle"] = "";
                $this->loadViews("reservation/edit", $this->global, $data, $data);
        }


             /**
         * This function is used to load the user list
         */
        function editDate($resId)
        {
                $data["projectInfo"] = $this->reservation_model->ReservationInfo($resId);
                $data["clientInfo"] = $this->user_model->getUserInfo($data["projectInfo"]->clientId);
                $data["contratInfo"] = $this->contrat_model->contratInfo($resId);
                $data["reseAvenir"] = $this->reservation_model->ReservationCalender1($data["projectInfo"]->salleId);
                $data["voiture"] = $this->voiture_model->ReservationInfo($data["projectInfo"]->voiture);
                $data["photographe"] = $this->photographe_model->ReservationInfo($data["projectInfo"]->photographe);
                $data["troupe"] = $this->troupe_model->ReservationInfo($data["projectInfo"]->troupe);
                $data["prestation"] = $this->prestation_model->ReservationListing($resId);
                $this->global["pageTitle"] = "Modification de la date de reservation ".$resId;
                $this->loadViews("reservation/datechange", $this->global, $data, $data);
        }

             /**
         * This function is used to load the user list
         */
        function verifier()
        {
                $data["salleRecords"] = $this->salle_model->SalleListing();
                $data["reseAvenir"] = $this->reservation_model->ReservationListing();

                $this->global["pageTitle"] = "Recherche de disponibilité des salles";
                $this->loadViews("reservation/verifier", $this->global, $data, $data);
        }

        /**
         * This function is used to load the user list
         */
        function generateContrat($resId)
        {
                $avance = $this->input->post("avance");
                $noteAdmin = $this->input->post("noteAdmin");
                
                $paiementInfo = ["createdDate" => date("Y-m-d H:i:s"), "valeur" => $avance, "recepteurId" => $this->vendorId, "libele" => "Avance", "reservationId" => $resId];
                $avanceId = $this->paiement_model->addNewPaiement($paiementInfo);
                $projectInfo = $this->reservation_model->ReservationInfo($resId);
                $nextyear = date("Y-m-d", strtotime($projectInfo->dateDebut . "  - 30  days"));
                
                $contratInfo = ["createdDate" => date("Y-m-d H:i:s"), "reservationID" => $resId, "avanceId" => $avanceId, "createdBy" => $this->vendorId, "deadline" => $nextyear, "statut" => 0];
                $this->contrat_model->addNewContrat($contratInfo);
                $reservationInfo = ["noteAdmin" => "Generation de contrat <br>".$noteAdmin, "statut" => 1];
                $this->reservation_model->editReservation($reservationInfo, $resId , $this->vendorId);
                
                $ReservationInfo = $this->reservation_model->ReservationInfo($resId);
                $clientInfo = $this->client_model->getClientInfo($ReservationInfo->clientId);
                $myMobile = $clientInfo->mobile;

              

                $mySmsK = "[NEW] ".$this->name . " a recu (" . $avance . " DT) salle : (". $ReservationInfo->salle .") pour le ". $ReservationInfo->dateDebut  ;
                $this->sendSMS("21655465244", $mySmsK , "Notif new admin");

                

                $mySmsH = "[NEW] ".$this->name . " a recu (" . $avance . " DT) salle : (". $ReservationInfo->salle .") pour le ". $ReservationInfo->dateDebut  ;
                $this->sendSMS("21698552446", $mySmsH , "Notif new admin");

                redirect("Reservation/view/" . $resId);
                

        }
        /**
         * This function is used to load the user list
         */
        function addPaiement($resId)
        {
                $avance = $this->input->post("avance");
                $noteAdmin = $this->input->post("noteAdmin");
                $paiementInfo = ["createdDate" => date("Y-m-d H:i:s"), "valeur" => $avance, "recepteurId" => $this->vendorId, "libele" => "Partie ", "reservationId" => $resId];
                $ReservationInfo = $this->reservation_model->ReservationInfo($resId);
                $clientInfo = $this->client_model->getClientInfo($ReservationInfo->clientId);
                $myMobile = $clientInfo->mobile;
                $mySms = "Salut " . $clientInfo->name . ", une paiement de (" . $avance . " DT)  pour la reservation N°" . $resId . " a été effectuée avec succées";
                $this->sendSMS("216" . $myMobile, $mySms , "Paiement");
                $this->paiement_model->addNewPaiement($paiementInfo);
                $totalPaiement = $this->paiement_model->getTotal($resId);
                $projectInfo = $this->reservation_model->ReservationInfo($resId);
                $reservationInfo = ["noteAdmin" => "Paiement de partie de  <br>".$noteAdmin, "statut" => 1];
                
                

                if ($projectInfo->prix - $totalPaiement->valeur == 0) {
                        $myMobile = $clientInfo->mobile;
                        $mySms = "Bonjour " . $clientInfo->name . ", votre reservation de la salle (" . $ReservationInfo->salle . ") pour le (" . $ReservationInfo->dateDebut . ") a été validée on vous souhaite une belle cérémonie.";
                        $this->sendSMS("216" . $myMobile, $mySms , "Reservation");


                $HediMobile = "98552446";
                $koussayMobile = "55465244";
                $mySms = $this->name . " a réçu le reste (" . $avance . " DT) salle (" . $ReservationInfo->salle . ") pour le " . $ReservationInfo->dateDebut ;
                $this->sendSMS("216" . $HediMobile, $mySms , "Notif admin");
                $this->sendSMS("216" . $koussayMobile, $mySms, "Notif admin" );

                        $reservationInfo = ["noteAdmin" => "Paiement de reste  <br>".$noteAdmin, "statut" => 0];


                }else 
                { 

                $HediMobile = "98552446";
                $koussayMobile = "55465244";

                $mySms = $this->name . " a réçu (" . $avance . " DT) pour la reservation de " . $ReservationInfo->salle . " pour le " . $ReservationInfo->dateDebut;
                
                $this->sendSMS("216" . $HediMobile, $mySms , "Notif admin");
                $this->sendSMS("216" . $koussayMobile, $mySms, "Notif admin" );

                }


                $this->reservation_model->editReservation($reservationInfo, $resId , $this->vendorId );
                redirect("Reservation/view/" . $resId);
        }
        

        function sendSMS($myMobile, $mySms , $type)
        {
            $smsInfo = array('destination'=>$myMobile,
                              'text' => $mySms,
                              'type' =>$type,
                              'createdBy'=>$this->vendorId,
                              'createdDtm'=>date('Y-m-d H:i:s') ,
                              'statut'=>1 ,

                            );
            $this->Sms_model->addNewSms($smsInfo) ; 

        }
}
?>
