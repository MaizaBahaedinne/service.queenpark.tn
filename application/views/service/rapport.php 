<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer"></i> Gestion des entrées
      <small>Ajout des entrées pour l’évènement du <?php echo $reservation->dateFin ?> à <?php echo $reservation->salle ?></small>
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12 col-xs-12">


<?php foreach($feedbacks as $fb): ?>
    <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">
        <p><strong>Note Salle :</strong> 
            <?= afficherEtoiles($fb['note_salle']); ?>
        </p>
        <p><strong>Note Service :</strong> 
            <?= afficherEtoiles($fb['note_service']); ?>
        </p>
        <p><strong>Commentaire :</strong> <?= htmlspecialchars($fb['commentaire']); ?></p>
        
        <?php if(!empty($fb['photo_user'])): ?>
            <img src="data:image/jpeg;base64,<?= $fb['photo_user']; ?>" alt="Photo utilisateur" style="max-width:150px; border-radius:8px;">
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php
function afficherEtoiles($note) {
    $max = 5;
    $output = '';
    for ($i=1; $i <= $max; $i++) {
        if ($i <= $note) {
            $output .= '⭐'; // étoile pleine
        } else {
            $output .= '☆'; // étoile vide
        }
    }
    return $output;
}
?>
              </div>
    </div>
  </section>
</div>