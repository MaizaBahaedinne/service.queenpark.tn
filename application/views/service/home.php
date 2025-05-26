<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Tableau de bord
        <small>Queen Park Services</small>
      </h1>
    </section>
     
    <section class="content">
       <div class="row">
            <div class="col-lg-4 col-xs-6">
             <a href="<?php echo base_url() ?>Reservation/entree/<?php echo $reservationId ?>"  class="small-box bg-aqua" >
              <div >
                <div class="inner">
                  <h3 style="color: white;">Entrées</h3>
                  <p></p>
                </div>
                <div class="icon">
                  <i class="ion ion-log-in"></i>
                </div>
                <a href="<?php echo base_url() ?>Reservation/entree/<?php echo $reservationId ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
              </a>
            </div>

             <div class="col-lg-4 col-xs-6">
             <a href="<?php echo base_url() ?>Reservation/sortie/<?php echo $reservationId ?>"  class="small-box bg-orange" >
              <div >
                <div class="inner">
                  <h3 style="color: white;">Retours</h3>
                  <p></p>
                </div>
                <div class="icon">
                  <i class="ion ion-log-out"></i>
                </div>
                <a href="<?php echo base_url() ?>Reservation/sotie/<?php echo $reservationId ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
              </a>
            </div>

            <div class="col-lg-4 col-xs-6">
             <a href="<?php echo base_url() ?>Reservation/satisfaction/<?php echo $reservationId ?>"  class="small-box bg-red" >
              <div >
                <div class="inner">
                  <h3 style="color: white;">Cloture</h3>
                  <p></p>
                </div>
                <div class="icon">
                  <i class="ion ion-happy"></i>
                </div>
                <a href="<?php echo base_url() ?>Reservation/sotie/<?php echo $reservationId ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
              </a>
            </div>    
             <div class="col-lg-12 col-xs-6">
              <a href="<?php echo base_url() ?>Reservation/afficherFeedback/<?php echo $reservationId ?>">rapport finale</a>
             </div>   

              <div class="col-lg-12 col-xs-6">
                  <!-- FullCalendar CSS -->
                  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

                  <!-- FullCalendar JS -->
                  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

                                    
                  <div id="calendar"></div>

                    
                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        var calendarEl = document.getElementById('calendar');

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                          initialView: 'timeGridWeek',
                          editable: true,
                          events: '/services/get_entrees_calander',
                          eventDrop: function(info) {
                            fetch('/services/update_entree_calander', {
                              method: 'POST',
                              headers: { 'Content-Type': 'application/json' },
                              body: JSON.stringify({
                                id: info.event.id,
                                start: info.event.start.toISOString(),
                                end: info.event.end.toISOString()
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

             </div>   


            
           
          </div>  
    </section>
   
</div>