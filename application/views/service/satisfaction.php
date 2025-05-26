<<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer"></i> Gestion des entrées
      <small>Ajout des entrées pour l’évènement du <?php echo $reservation->dateFin ?> à <?php echo $reservation->salle ?></small>
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12 col-xs-12">

          <h2>Rapport d'utilisation</h2>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nature</th>
                <th>Moment</th>
                <th>Quantité prévue</th>
                <th>Quantité retournée</th>
                <th>Consommée</th>
                <th>Note</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($rapport as $item): ?>
                <tr>
                  <td><?= ucfirst($item->nature) ?></td>
                  <td><?= $item->moment_service ?></td>
                  <td><?= $item->quantite ?></td>
                  <td><?= $item->quantiteRetournee ?></td>
                  <td><?= $item->quantite - $item->quantiteRetournee ?></td>
                  <td><?= $item->noteRetour ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <h3>Votre retour</h3>
          <form method="post" action="<?= base_url() ?>Reservation/saveFeedback/<?= $reservation->reservationId ?>">
            <label>Note salle :</label>
            <input type="range" name="note_salle" min="1" max="5" required> ★<br>

            <label>Note service :</label>
            <input type="range" name="note_service" min="1" max="5" required> ★<br>

            <label>Commentaire :</label>
            <textarea name="commentaire"></textarea><br>

            <label>
              <input type="checkbox" id="photo_ok"> J'accepte qu'on prenne une photo souvenir
            </label><br>

            <video id="webcam" width="320" height="240" autoplay style="display:none;"></video>
            <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
            <input type="hidden" name="photo_base64" id="photo_input">

            <button type="button" onclick="takeSnapshot()">📸 Prendre la photo</button>
            <button type="submit">Envoyer</button>
          </form>


              </div>
    </div>
  </section>
</div>

          <script>
          const video = document.getElementById('webcam');
          const canvas = document.getElementById('canvas');
          const photoInput = document.getElementById('photo_input');
          const checkbox = document.getElementById('photo_ok');

          checkbox.addEventListener('change', function() {
              if (this.checked) {
                  navigator.mediaDevices.getUserMedia({ video: true })
                  .then(stream => {
                      video.srcObject = stream;
                      video.style.display = 'block';
                  });
              } else {
                  video.srcObject = null;
                  video.style.display = 'none';
              }
          });

          function takeSnapshot() {
              if (!checkbox.checked) return alert("Tu dois accepter pour prendre une photo");
              canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
              const dataUrl = canvas.toDataURL('image/jpeg');
              photoInput.value = dataUrl;
              alert("Photo prise avec succès ✔");
          }
          </script>
