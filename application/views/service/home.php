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
            <div class="col-lg-3 col-xs-6">
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
            <div class="col-lg-3 col-xs-6">
             
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>53<sup style="font-size: 20px">%</sup></h3>
                  <p>Taches</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bookmark"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>44</h3>
                  <p>Retour</p>
                </div>
                <div class="icon">
                  <i class="ion ion-log-out"></i>
                </div>
                <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
            
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>65</h3>
                  <p>Rapport et satifaction</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>  
    </section>
   
</div>