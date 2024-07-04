
<?php include "availability_search.php"; ?>
   <!-- Projects Row -->
   <div class="card" style="margin-top: 10px;">
      <div class="card-header">
        <h1>Welcome to our Mini Hotel</h1>
      </div>
      <div class="card-body">
        <div class="col-md-12">
           <!-- <a href="portfolio-item.html"> -->
                <img style="width: 100%;" class="" src="<?php echo WEB_ROOT; ?>images/room1.jpg" alt="">
            <!-- </a>   -->
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-6" >
                <h3>Contact Info</h3>
                  <p><i class="fa fa-building-o fa-fw pull-left fa-2x"></i>Madridejos Community College</p>
                  <div class="space"></div>
                  <p><i class="fa fa-map-marker fa-fw pull-left fa-2x"></i> Bunakan,Madridejos,Cebu <br>
                                        </p>
                  <div class="space"></div>
                  <p><i class="fa fa-envelope-o fa-fw pull-left fa-2x"></i>Hmhotel@gmail.com</p>
                  <div class="space"></div>
                  <p><i class="fa fa-phone fa-fw pull-left fa-2x"></i>09317622381</p>
            </div>
            <div class="col-md-6" >
                <div class="page-header"><h2>Type Of Rooms</h2></div>
                <div class="list-group">
                
                    <?php
                          $query = "SELECT distinct(ROOM) FROM `tblroom` ";
                         $mydb->setQuery($query);
                         $cur = $mydb->loadResultList();  
                            ?>
                            
                      <?php  foreach ($cur as $result) { ?>
                        <a class="list-group-item list-group-item-action" href="<?php echo WEB_ROOT; ?>index.php?p=rooms&q=<?php echo $result->ROOM; ?>" ><?php echo $result->ROOM; ?></a>
                      <?php  } ?>
                      </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <div id="carouselExampleCaptions" class="carousel slide" style="max-height: 800px; display: flex; align-items: center; background-color: whitesmoke; padding: 20px;">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                  </div>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img src="<?php echo WEB_ROOT; ?>images/room.jpg" class="d-block w-100" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Standard Room</h5>
                        <p>&#8369 800</p>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <img src="<?php echo WEB_ROOT; ?>images/room1.jpg" class="d-block w-100" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Travellers Time</h5>
                        <p>&#8369 1000</p>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <img src="<?php echo WEB_ROOT; ?>images/header-bg1.jpg" class="d-block w-100" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Bayanihan Rooms</h5>
                        <p>&#8369 1000</p>
                      </div>
                    </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
            </div>
        </div>
        
      </div>
    </div>

                
                