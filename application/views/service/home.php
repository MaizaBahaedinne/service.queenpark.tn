<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer" aria-hidden="true"></i> Tableau de bord
      <small>Queen Park Services</small>
    </h1>
  </section>

  <section class="content">
    <div class="row">

      <!-- Entrée -->
      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3 style="color: white;">Entrées</h3>
          </div>
          <div class="icon">
            <i class="ion ion-log-in"></i>
          </div>
          <a href="<?php echo base_url() ?>Reservation/entree/<?php echo $reservationId ?>" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Sortie -->
      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-orange">
          <div class="inner">
            <h3 style="color: white;">Retours</h3>
          </div>
          <div class="icon">
            <i class="ion ion-log-out"></i>
          </div>
          <a href="<?php echo base_url() ?>Reservation/sortie/<?php echo $reservationId ?>" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Clôture -->
      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <h3 style="color: white;">Clôture</h3>
          </div>
          <div class="icon">
            <i class="ion ion-happy"></i>
          </div>
          <a href="<?php echo base_url() ?>Reservation/satisfaction/<?php echo $reservationId ?>" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Rapport final -->
      <div class="col-lg-12 col-xs-6">
        <p>
          <a href="<?php echo base_url() ?>Reservation/afficherFeedback/<?php echo $reservationId ?>" class="btn btn-primary">
            Voir le rapport final
          </a>
        </p>
      </div>

      <!-- CALENDRIER -->
      <div class="col-lg-12 col-xs-12">
        <h3><i class="fa fa-calendar"></i> Planning de la réservation</h3>
        <div id="calendar"></div>
      </div>

    </div>
  </section>
</div>

<!-- FullCalendar (en bas de page ou dans le <head> si possible) -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek',
      editable: true,
      height: 'auto',

      // Tu peux personnaliser ici avec les horaires/dates spécifiques
       slotMinTime: '<?php echo $reservation->heureDebut ;?>:00',
       slotMaxTime: '<?php echo $reservation->heureFin ;?>:00',
      // validRange: {
      //   start: '2025-05-30',
      //   end: '2025-05-31'
      // },

      events: '/services/get_entrees_calander',
      eventDrop: function (info) {
        fetch('/services/update_entree_calander', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            id: info.event.id,
            start: info.event.start.toISOString(),
            end: info.event.end ? info.event.end.toISOString() : null
          })
        })
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            alert('Erreur lors de la mise à jour.');
            info.revert();
          }
        })
        .catch(() => {
          alert('Erreur serveur.');
          info.revert();
        });
      }
    });

    calendar.render();
  });
</script>
