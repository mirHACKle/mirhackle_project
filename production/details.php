<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

session_start();

try {
    $bdd= new PDO('mysql:host=localhost; dbname=datamap','root','virtuel',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $requet= $bdd->prepare('SELECT time, COUNT(time) AS nbrHost FROM data GROUP BY time ORDER BY time DESC limit 2');
    $requet->execute();
    // set the resulting array to associative
    $resultLast = $requet->fetch();
    $resultPrevious = $requet->fetch();

    $queryString = 'SELECT service FROM data WHERE time = \''.$resultLast['time'].'\'';
    $requete = $bdd->prepare($queryString);
    $requete->execute();
    $services = $requete->fetchAll();

    $allServices = array();

    foreach ($services as $key => $value) {
        $temp = explode(",", $value['service']);
        // foreach ($temp as $key1 => $service) {
        foreach ($temp as $key1 => $service) {
          if(array_key_exists($service, $allServices)){
            $allServices[$service]++;
          }
          else{
            $allServices[$service] = 1;
          }
        }
        // }
    }
    $totalService=0;
    foreach ($allServices as $key => $value) {
        $totalService+=$value;
    }


    // var_dump($allServices);
    // die();

    // $bdd->close();

}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

    $bddSnort= new PDO('mysql:host=localhost; dbname=snort','root','virtuel',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $requete = $bddSnort->prepare('SELECT * FROM event WHERE vu=0');
    $requete->execute();

    $requeteEvent = $bddSnort->prepare('SELECT * FROM event INNER JOIN sig_class ON event.sid = sig_class.sig_class_id');
    $requeteEvent->execute();

    $events = $requeteEvent->fetchAll();

    // var_dump($events); die();

    $notifications = $requete->fetchAll();

    $bddOssec= new PDO('mysql:host=localhost; dbname=ossec','root','virtuel',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>mirHACKle|Home</title>

    <!--<script type="text/javascript" src="js/jquery.js"></script> -->

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/home.css">

    <script type="text/javascript" src="js/highcharts.js"></script>
    <script type="text/javascript" src="js/highcharts-more.js"></script>
    <script type="text/javascript" src="js/exporting.js"></script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; margin-top: 5px; margin-left: 0px;">
                    <img src="../src/images/mirhackle/mirhackle_logo.png" style="width:50px; margin-left:5px;">
                    <img src="../src/images/mirhackle/mirhackle_text.png" style="width:40%; margin-left:15%; min-width:0px;">
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="../src/images/user/din.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenue,</span>
                <h2>Admin</h2>
              </div>
              <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="notifications">
                  <span class="fa fa-envelope-o"></span></button><span class="badge bg-red" style="margin-left:-15px; margin-top: -15px;" id="notification_number"><?= (count($notifications)==0)?'':count($notifications); ?></span>
                  <ul class="dropdown-menu">
<!--                     <li><a href="#">HTML</a></li>
                    <li><a href="#">CSS</a></li>
                    <li><a href="#">JavaScript</a></li> -->
                  </ul>
              </div>
            </div>

            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>_________________</h3>
                <ul class="nav side-menu">
                  <li><a href="home.php"><i class="fa fa-home"></i> Tableau de bord <span class="fa fa-chevron-down"></span></a>
                  </li>
                  <li class="active"><a><i class="fa fa-bar-chart-o"></i> Détails techniques <span class="fa fa-chevron-right"></span></a> 
                  </li>
                  <li><a href="index.php"><i class="fa fa-sign-out"></i> se déconnecter</span></a> 
                  </li>
                  

                </ul>
              </div>
              <div class="menu_section">
                
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <div class="row">
                <div class="col-md-2 col-sm-8">
                </div>
                <div class="integrity col-md-2 col-sm-4">
                  <div class="integrity-content">
                    <a href="javascript:void(0);"><img class="integrity-picture" src="images/icon_integrity/integrite.png"><br>Integrité</a>
                  </div>
                </div>
                <div class="integrity col-md-2 col-sm-4">
                   <div class="integrity-content">
                    <a href="javascript:void(0);"><img class="integrity-picture" src="images/icon_integrity/disponibilite.png"><br>Disponibilité</a>
                  </div> 
                </div>
                <div class="integrity col-md-2 col-sm-4">
                  <div class="integrity-content">
                    <a href="javascript:void(0);"><img class="integrity-picture" src="images/icon_integrity/confidentialite.png"><br>Confidentialité</a>
                  </div>
                </div>
                <!-- <div class="col-md-2 col-sm-4">
                </div> -->

                <div class="col-md-2 col-sm-4">
                  <div class="container">
                      <button class="btn btn-lg btn-warning" data-toggle="modal" data-target="#modalAudit" id="start_scan"><span class="glyphicon glyphicon-refresh" id="start_scan_icon"></span>Evaluer maintenant</button>
                  </div>

                </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                </li>
                <li>
                  
                    <!-- <a class="btn btn-default submit" id="start_scan" href="javascript:void(0);" style="background-color: #009900; color: white !important; padding-top:10px; font-weight: bold;">Scanner maintenant</a> -->
                </li>

                 


               
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total des vulnérabilités</span>
              <div class="count">250</div>
              <span class="count_bottom"><i class="green">4% </i> </span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Dernier scan effectué</span>
              <div class="count">
                <?php 
                  $now = new DateTime();
                  $last = new DateTime($resultLast['time']);
                  $temps = $now->diff($last); 
                  echo $temps->format("%dj, %Hh, %im");
                ?></div>
            </div>
            <!-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
              <div class="count green">2,500</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
              <div class="count">4,567</div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
              <div class="count">2,315</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div> -->
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Nombre total d'hôtes</span>
              <div class="count"><?php echo $resultLast['nbrHost'];?></div>
              <span class="count_bottom"><i class="green"><i class="fa <?php $evolutionHost = (($resultLast['nbrHost']-$resultPrevious['nbrHost'])*100)/$resultPrevious['nbrHost'];
                                                        if($evolutionHost>0) echo "fa-sort-asc green";  else echo "fa-sort-desc red"; ?> "></i><?= abs($evolutionHost) ?>% </i></span>
            </div>
          </div>
          <!-- /top tiles -->

          <div class="row">
              <div class="col-md-6 col-sm- col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Evènements Réseau<small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <!-- <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="height: 60vh; overflow-y:auto;">

                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Evènement</th>
                          <th>Gravité</th>
                          <th>Correctif</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($events as $key => $event) {

                            ?>


                              <tr>
                                <td><?= $event['timestamp'] ?></td>
                                <td><?= $event['traduction'] ?></td>
                                <td><?= $event['code_erreur'] ?></td>
                                <td><?= $event['solution'] ?></td>
                              </tr>


                              <?php
                          }
                        

                        ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm- col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Evènements Système <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <!-- <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="height: 60vh; overflow-y:auto;">

                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Evènement</th>
                          <th>Gravité</th>
                          <th>Correctif</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($events as $key => $event) {

                            ?>


                              <tr>
                                <td><?= $event['timestamp'] ?></td>
                                <td><?= $event['traduction'] ?></td>
                                <td><?= $event['code_erreur'] ?></td>
                                <td><?= $event['solution'] ?></td>
                              </tr>


                              <?php
                          }
                        

                        ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-2 col-xs-11"></div>
          </div>
          <br />

          <div class="row">

          </div>


          <div class="row">

          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">

          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- Modal -->
    <div id="modalAudit" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Veuillez cocher les modules que vous avez.</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-10">
              <div></div>
                <div class="checkbox">
                  <label><input type="checkbox" value="">BackUp de base de données</label>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" value="">Serveur de relais</label>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" value="">Serveur web sécurisé (https://)</label>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" value="">Option 1</label>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" value="">Option 1</label>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" value="">Option 1</label>
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="button" id="launch_analysis" class="btn btn-default" data-dismiss="modal">Lancer l'analyse</button>
          </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script type="text/javascript">
      $(function(){
        $('#notifications').click(function(){
          $.ajax({
            url: 'delete_notif.php',
            type: 'post',
            dataType: 'text',
            success:function(result){
              $('#notification_number').text = '';
              // alert("vu");    
            },
            error:function(xhr, error, kjkk){
              alert(error.responseText);
            }
          });
        })
      })
    </script>

    <!-- LANCER UN SCAN -->

    <script type="text/javascript">
      $(function(){
        $("#launch_analysis").click(function(){
          // alert("Lancement du scan");
          $("#start_scan_icon").addClass("glyphicon-refresh-animate");

          $.ajax({
            url : 'start_scan.php',
            type: 'post',
            dataType: 'text',
            success:function(result){
              $("#start_scan_icon").removeClass("glyphicon-refresh-animate");
              alert("Scan terminer");
            },
            error:function(xhr, request, error){
              alert(xhr.responseText);
              alert(error.message);
            }
          });
        })
      })
    </script>

    <script type="text/javascript">
      $(function(){
        $(".integrity").click(function(){
          // alert("click");
          $button = $(this);
          if($button.hasClass("integrity-picture-active"))
            $button.removeClass("integrity-picture-active");
          else
            $button.addClass("integrity-picture-active");
        });
      });
    </script>
  </body>
</html>
