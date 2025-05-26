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
        <div style="display: flex; gap: 20px;">
          <!-- Calendrier -->
          <div id="calendar" style="flex: 1;"></div>

          <!-- Liste des événements non planifiés -->
          <div id="external-events" style="width: 300px;">
            <h4>Entrées à planifier</h4>
            <div id="event-list">
              <!-- Les éléments à dragger seront injectés ici -->
            </div>
          </div>
      </div>

      </div>

    </div>
  </section>
</div>

<!-- FullCalendar (en bas de page ou dans le <head> si possible) -->

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/fr.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const eventList = document.getElementById('event-list');

    // Charger les événements non planifiés
    fetch('/Services/get_entrees_non_planifiees')
      .then(res => res.json())
      .then(events => {
        events.forEach(event => {
          const el = document.createElement('div');
          el.innerText = event.title;
          el.classList.add('fc-event');
          el.setAttribute('data-id', event.id);
          el.setAttribute('data-title', event.title);
          el.setAttribute('draggable', true);
          eventList.appendChild(el);
        });

        new FullCalendar.Draggable(eventList, {
          itemSelector: '.fc-event',
          eventData: function (el) {
            return {
              id: el.getAttribute('data-id'),
              title: el.getAttribute('data-title'),
              duration: '00:30'
            };
          }
        });
      });

    // Initialiser le calendrier
    const calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'fr',
      initialView: 'timeGridDay',
      editable: true,
      droppable: true,
      height: 'auto',
      slotMinTime: '<?php echo $reservation->heureDebut ;?>:00',
      slotMaxTime: '<?php echo $reservation->heureFin ;?>:00',
      events: '/Services/get_entrees_calander/<?= $reservation->reservationId ?>',

      eventReceive: function (info) {
        const id = info.event.id;
        const start = info.event.start.toISOString();

        fetch('/Services/update_entree_calander', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id, start })
        })
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            alert("Erreur serveur !");
            info.revert();
          }
        })
        .catch(() => {
          alert("Erreur réseau !");
          info.revert();
        });
      },

      eventDrop: function (info) {
        const id = info.event.id;
        const start = info.event.start.toISOString();

        fetch('/Services/update_entree_calander', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id, start })
        })
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            alert("Erreur serveur !");
            info.revert();
          }
        })
        .catch(() => {
          alert("Erreur réseau !");
          info.revert();
        });
      }
    });

    calendar.render();
  });
</script>
