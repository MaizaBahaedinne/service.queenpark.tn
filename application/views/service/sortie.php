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

  .row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .col {
    flex: 1;
    min-width: 150px;
    display: flex;
    flex-direction: column;
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
      <small>Ajout des retours pour l’évènement du <?php echo $reservation->dateFin ?> à <?php echo $reservation->salle ?></small>
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <h3>Retours après consommation</h3>

        <form method="post" action="<?php echo base_url() ?>Reservation/addRetours/<?php echo $reservation->reservationId ?>" class="form-style">
          <?php foreach ($entrees as $entree) : ?>
            <div class="entree-row retour-entry mb-4 p-3">
              <h4><?= $entree->quantite ?>x <?= ucfirst($entree->nature) ?> </h4>

              <input type="hidden" name="entree_id[]" value="<?= $entree->entreeId ?>">

              <div class="mb-2">
                <label>Quantité retournée :</label>
                <input type="number" name="quantite_retour[]" min="0" max="<?= $entree->quantite ?>" min="0" class="form-control" required>
                <small class="text-muted">Indique combien n’a pas été utilisé</small>
              </div>

              <div class="mb-2">
                <label>Note / Commentaire :</label>
                <textarea name="note_retour[]" class="form-control" rows="2" placeholder="Ex : Renvoyé, pas utilisé, etc."></textarea>
              </div>
            </div>
          <?php endforeach; ?>

          <button type="submit" class="btn btn-primary">Enregistrer </button>
        </form>
      </div>
    </div>
  </section>
</div>
