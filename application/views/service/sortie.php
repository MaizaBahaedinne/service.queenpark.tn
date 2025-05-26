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
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer"></i> Gestion des retours
      <small>Ajout des retours pour l’évènement du <?= $reservation->dateFin ?> à <?= $reservation->salle ?></small>
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <h3>Retours après consommation</h3>

        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
          </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger">
            <?= $this->session->flashdata('error') ?>
          </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url("Reservation/addRetours/{$reservation->reservationId}") ?>" class="form-style">

          <?php foreach ($entrees as $entree): 
            $retourExistant = null;

            foreach ($retours as $retour) {
              if ((int)$retour->entreeId === (int)$entree->entreeId) {
                $retourExistant = $retour;
                break;
              }
            }

            $quantite_retour = $retourExistant ? $retourExistant->quantite_retour : '';
            $note_retour = $retourExistant ? htmlspecialchars($retourExistant->note_retour) : '';
            $readonly = $retourExistant !== null; // Si un retour existe, c’est readonly
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
      </div>
    </div>
  </section>
</div>
