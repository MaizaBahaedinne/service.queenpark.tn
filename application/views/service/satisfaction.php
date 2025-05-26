<style>
  
  .rating-stars {
  direction: rtl;
  font-size: 2.5rem;
  unicode-bidi: bidi-override;
  display: inline-flex;
  margin-bottom: 20px;
}

.rating-stars input {
  display: none;
}

.rating-stars label {
  color: #ccc;
  cursor: pointer;
  transition: color 0.3s ease;
  padding: 0 5px;
}

.rating-stars label:hover,
.rating-stars label:hover ~ label,
.rating-stars input:checked ~ label {
  color: #f5b301;
  text-shadow: 0 0 5px #f5b301;
}


</style>


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
              <div class="feedback-wrapper">
  <h3>Donnez votre avis</h3>
  
        <form method="post" action="<?php echo base_url('Reservation/saveFeedback/'.$reservation->reservationId) ?>" enctype="multipart/form-data" id="feedbackForm">

          <!-- Note Salle -->
          <label>Note pour la salle :</label>
          <div class="rating-stars" id="rating_salle">
            <input type="radio" id="salle5" name="rating_salle" value="5" />
            <label for="salle5" title="Excellent">&#9733;</label>

            <input type="radio" id="salle4" name="rating_salle" value="4" />
            <label for="salle4" title="Très bien">&#9733;</label>

            <input type="radio" id="salle3" name="rating_salle" value="3" />
            <label for="salle3" title="Moyen">&#9733;</label>

            <input type="radio" id="salle2" name="rating_salle" value="2" />
            <label for="salle2" title="Pas terrible">&#9733;</label>

            <input type="radio" id="salle1" name="rating_salle" value="1" />
            <label for="salle1" title="Nul">&#9733;</label>
          </div>

          <!-- Note Service -->
          <label>Note pour le service :</label>
          <div class="rating-stars" id="rating_service">
            <input type="radio" id="service5" name="rating_service" value="5" />
            <label for="service5" title="Excellent">&#9733;</label>

            <input type="radio" id="service4" name="rating_service" value="4" />
            <label for="service4" title="Très bien">&#9733;</label>

            <input type="radio" id="service3" name="rating_service" value="3" />
            <label for="service3" title="Moyen">&#9733;</label>

            <input type="radio" id="service2" name="rating_service" value="2" />
            <label for="service2" title="Pas terrible">&#9733;</label>

            <input type="radio" id="service1" name="rating_service" value="1" />
            <label for="service1" title="Nul">&#9733;</label>
          </div>

          <!-- Champ caché pour la photo en base64 -->
          <input type="hidden" name="photo_base64" id="photo_base64" />

          <button type="submit" class="btn btn-primary">Envoyer mon avis</button>
        </form>

        <video id="video" width="320" height="240" autoplay muted style="display:none;"></video>
      </div>



              </div>
    </div>
  </section>
</div>

          <script>
          // On active la webcam au chargement pour préparer la prise de photo
          const video = document.getElementById('video');
          const photoInput = document.getElementById('photo_base64');

          navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(stream => {
              video.srcObject = stream;
            })
            .catch(err => {
              console.warn('Webcam non accessible', err);
            });

          // Au submit, on capture une image, on encode en base64, on met dans le champ caché
          document.getElementById('feedbackForm').addEventListener('submit', async function(e){
            e.preventDefault();

            // Création d'un canvas pour capturer le frame
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth || 320;
            canvas.height = video.videoHeight || 240;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // encode en base64
            const dataUrl = canvas.toDataURL('image/jpeg');

            // on place dans le champ caché
            photoInput.value = dataUrl;

            // submit après avoir ajouté la photo
            this.submit();
          });

          </script>
