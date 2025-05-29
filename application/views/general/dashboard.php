<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Tableau de bord
        <small>Queen Park Services</small>
      </h1>
    </section>
     <!--
    <section class="content">
       <div class="row">
            <div class="col-lg-3 col-xs-6">
             
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>150</h3>
                  <p>New Tasks</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
             
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>53<sup style="font-size: 20px">%</sup></h3>
                  <p>Completed Tasks</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>44</h3>
                  <p>New User</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
            
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>65</h3>
                  <p>Reopened Issue</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>  
    </section>-->
    <section class="content">
     <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Mes Affecations</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>date & heure</th>
                        <th>salle</th>
                        <th>Evénement</th>
                        <th>option</th>
						           
                        
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo date_format(date_create($record->dateFin)  , 'd/m/20y');  ?><br><?php echo $record->heureDebut ?></td>
                        <td><?php echo $record->salle ?></td>
                        <td><?php echo $record->type ?><br><?php echo $record->titre ?></td>
                        <td>
                          <?php if ($record->cuisine == 1 ){ echo '<i class="fas fa-utensils"></i> ';}  ?>
                          <?php if ($record->tableCM == 1 ){ echo '<i class="fa fa-file" ></i> ';}  ?>
                        </td>
                       
                        <td class="text-center">
                          <?php
                              $now = new DateTime();
                              $dateFin = new DateTime($record->dateFin);
                              $debut = (clone $dateFin)->setTime(0, 0);
                              $fin = (clone $dateFin)->modify('+1 day')->setTime(3, 0);
                              ?>

                              <?php if ($now >= $debut && $now <= $fin): ?>
                                  <a class="btn btn-sm btn-primary btn-block" href="<?= base_url().'Reservation/service/'.$record->reservationId; ?>" title="Edit">
                                      <i class="fa fa-eye"></i> Service
                                  </a>
                              <?php else: ?>
                                  <?php
                                  $diff = $now->diff($dateFin);
                                  echo ($diff->invert ? "Échéance dépassée" : "Jours restants : " . $diff->days + 1);
                                  ?>
                              <?php endif; ?>

                              <?php if ($is_admin == 1 ) : ?>
                               <a class="btn btn-sm btn-primary btn-block" href="<?= base_url().'Reservation/service/'.$record->reservationId; ?>" title="Edit">
                                      <i class="fa fa-eye"></i> Service
                                  </a>
                              <?php endif; ?>
                           
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>