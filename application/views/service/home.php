

<style>
  #event-list {
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 0.5rem;
    min-height: 100px;
    border: 2px dashed #dee2e6;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .fc-event {
    padding: 8px 12px;
    background-color: #0d6efd;
    color: white;
    border-radius: 0.3rem;
    cursor: grab;
    font-size: 14px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.1s ease;
  }

  .fc-event:hover {
    transform: scale(1.03);
    background-color: #0b5ed7;
  }

  /* Bouton supprimer dans l'event */
  .delete-btn {
    background: red;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 2px 6px;
    margin-left: 5px;
    cursor: pointer;
    font-weight: bold;
  }
</style>


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
        <div class="small-box <?php if (count($retours) == 0)  { ?>bg-aqua<?php } else  {  ?>bg-grey<?php } ?> ">
          <div class="inner">
            <h3 style="color: white;">Entrées </h3>
            <p><?php echo count($entrees) ?></p>
          </div>
          <div class="icon">
            <i class="ion ion-log-in"></i>
          </div>
          <a href="<?php if (count($retours) == 0)  {  echo base_url() ?>Reservation/entree/<?php echo $reservationId;  }  ?>" class="small-box-footer">
            entrer <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Sortie -->
      <div class="col-lg-4 col-xs-6">
        <div class="small-box <?php if ( (count($entrees) > 0 ) && (count($retours) == 0)  )  { ?>bg-orange<?php } else  {  ?>bg-grey<?php } ?>">
          <div class="inner">
            <h3 style="color: white;">Retours</h3>
            <p><?php echo count($retours) ?></p>
          </div>
          <div class="icon">
            <i class="ion ion-log-out"></i>
          </div>
          <a href="<?php  if ( (count($entrees) > 0 ) && (count($retours) == 0)  )  { echo base_url() ?>Reservation/sortie/<?php echo $reservationId ; } ?>" class="small-box-footer">
            Entrer <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Clôture -->
      <div class="col-lg-4 col-xs-6">
        <div class="small-box <?php if ( (count($entrees) > 0 ) && (count($retours) > 0)  )  { ?>bg-red<?php } else  {  ?>bg-grey<?php } ?>">
          <div class="inner">
            <h3 style="color: white;">Clôture</h3>
            <p><?php echo count($rapport) ?></p>
          </div>
          <div class="icon">
            <i class="ion ion-happy"></i>
          </div>
          <a href="<?php if ( (count($entrees) > 0 ) && (count($retours) > 0)  )  {  echo base_url() ?>Reservation/satisfaction/<?php echo $reservationId ; } ?>" class="small-box-footer">
            Entrer <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Rapport final -->
      <div class="col-lg-12 col-xs-6">
        <p>
          <a href="<?php echo base_url() ?>Reservation/afficherFeedback/<?php echo $reservationId ?>" class="btn btn-block btn-primary">
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




<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/fr.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const eventList = document.getElementById('event-list');

  // Charger événements non planifiés pour drag & drop
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

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'timeGridDay',
    editable: true,
    droppable: true,
    height: 'auto',
    slotMinTime: '<?php echo $reservation->heureDebut ;?>:00',
    slotMaxTime: '<?php echo $reservation->heureFin ;?>:00',
    slotDuration: '00:15:00',
    slotLabelInterval: '00:15:00',
    locale: 'fr',

    // Afficher titre après l'heure + bouton supprimer
    eventContent: function(arg) {
      const timeText = arg.timeText;
      const titleText = arg.event.title;

      return {
        html: `
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <span>${timeText} - <strong>${titleText}</strong></span>
            <button class="delete-btn" data-id="${arg.event.id}">x</button>
          </div>
        `
      };
    },

    // Listener pour bouton supprimer
    eventDidMount: function(info) {
      const btn = info.el.querySelector('.delete-btn');
      if (btn) {
        btn.addEventListener('click', function(e) {
          e.stopPropagation(); // Pas déclencher eventClick
          const eventId = info.event.id;
          if (confirm("Supprimer cette planification ?")) {
            fetch('/Services/delete_entree_calander', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ id: eventId })
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                info.event.remove();
              } else {
                alert("Erreur serveur lors de la suppression.");
              }
            })
            .catch(() => alert("Erreur réseau lors de la suppression."));
          }
        });
      }
    },

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
        body: JSON.stringify({ id, start  })
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
