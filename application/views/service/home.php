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
            
           
          </div>  
    </section>
   
</div>