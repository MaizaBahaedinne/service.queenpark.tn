<style>
  .form-style {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    max-width: 1000px;
    margin: auto;
  }
  .entree-row {
    border: 1px solid #ccc;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 8px;
    background-color: #fafafa;
  }
  input, select, button, textarea {
    padding: 8px;
    margin-top: 5px;
    font-size: 14px;
  }
  button {
    cursor: pointer;
  }
  .form-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
  }
  .btn-primary {
    background-color: #007bff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
  }
</style>

<div class="content-wrapper">
  <<section class="content-header">
  <div style="display: flex; align-items: center; gap: 15px;">
    <!-- Bouton retour à l'accueil -->
    <a href="<?php echo base_url('Reservation/service/' . $reservation->reservationId); ?>" class="btn btn-default">
      <i class="fa fa-arrow-left"></i> Retour
    </a>

    <!-- Titre principal -->
    <div>
      <h2 style="margin: 0;">
        <i class="fa fa-tachometer"></i> Gestion des retours
      </h2>
      <small>
        Les retours pour l’évènement du <?php echo $reservation->dateFin ?> à <?php echo $reservation->salle ?>
      </small>
    </div>
  </div>
</section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <h3>Retours après consommation</h3>

        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <?php if(coiunt($retours) == 0 ) :  ?>
        <form method="post" action="<?= base_url("Reservation/addRetours/{$reservation->reservationId}") ?>" class="form-style">
          
          <?php foreach ($entrees as $entree): 
            // Cherche un retour existant pour cette entrée
            $retourExistant = null;
            foreach ($retours as $retour) {
              if ($retour->entreeId == $entree->entreeId) {
                $retourExistant = $retour;
                break;
              }
            }

            // Récupère les données avec sécurité
            $quantite_retour = isset($retourExistant->quantite_retour) ? $retourExistant->quantite_retour : '';
            $note_retour = isset($retourExistant->note_retour) ? htmlspecialchars($retourExistant->note_retour) : '';
            $readonly = $quantite_retour !== ''; // si une valeur existe, on bloque
          ?>
            <div class="entree-row retour-entry mb-4 p-3">
              <h4><?= $entree->quantite ?>x <?= ucfirst($entree->nature) ?></h4>

              <input type="hidden" name="entree_id[]" value="<?= $entree->entreeId ?>">

              <div class="mb-2">
                <label>Quantité retournée :</label>
                <input
                  type="number"
                  name="quantite_retour[]"
                  min="0"
                  step="0.1"
                  max="<?= $entree->quantite ?>"
                  class="form-control"
                  required
                  value="<?= $quantite_retour ?>"
                  <?= $readonly ? 'readonly' : '' ?>
                >
                <small class="text-muted">Indique combien n’a pas été utilisé</small>
              </div>

              <div class="mb-2">
                <label>Note / Commentaire :</label>
                <textarea
                  name="note_retour[]"
                  class="form-control"
                  rows="2"
                  placeholder="Ex : Renvoyé, pas utilisé, etc."
                  <?= $readonly ? 'readonly' : '' ?>
                ><?= $note_retour ?></textarea>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="form-buttons">
            <button type="submit" class="btn btn-primary">Enregistrer les retours</button>
          </div>
        </form>
        <?php else : ?>
          <div class="alert alert-info" role="alert" style="margin-top: 15px;">
            <i class="fa fa-info-circle"></i> 
            Les retours ont déjà été saisis. Vous pouvez maintenant passer au <a href="<?php echo base_url('Reservation/satisfaction//'.$reservation->reservationId); ?>">formulaire de satisfaction client</a>.
          </div>
        <?php endif ; ?>
      </div>
    </div>
  </section>
</div>
