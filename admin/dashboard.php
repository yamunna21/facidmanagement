                <?php

                include('../class/Appointment.php');

				$object = new Appointment;

				if(!$object->is_login())
				{
				    header("location:".$object->base_url."");
				}

                if($_SESSION['type'] != 'Admin')
                {
                    header("location:".$object->base_url."");
                }

                include('header.php');

                $connect = mysqli_connect("localhost", "root", "", "facidsystem");  
                $query = "SELECT patient_status, count(*) as number FROM patients_table GROUP BY patient_status";  
                $result = mysqli_query($connect, $query);  

                ?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

                    <!-- Content Row -->
                    <div class="row row-cols-5">
                        
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Today Total Registered Patient</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_patient(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Last 14 Days Total Patient</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_14_patient(); ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Last 21 Days Total Patient</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_21_day_patient(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Registered Patient</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_patient(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Registered Doctor</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_doctor(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <style type="text/css"> 
                      .margin{ 
                        margin-top: -1px;   
                        margin-right: -20px;  
                        margin-left: 390px;  
                         } 

                      .google{ 
                        margin-top: -1px;  
                        margin-bottom: 200px;  
                        margin-right: -20px;  
                        margin-left: 10px;  
                         } 
                    </style>
                         <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
                         <script type="text/javascript">  
                                 google.charts.load('current', {'packages':['corechart']});  
                                 google.charts.setOnLoadCallback(drawChart);  
                                  function drawChart()  
                                  {  
                                   var data = google.visualization.arrayToDataTable([  
                                   ['Status', 'Number'],  
                                    <?php  
                                     while($row = mysqli_fetch_array($result))  
                                     {  
                                     echo "['".$row["patient_status"]."', ".$row["number"]."],";  
                                     }  
                                     ?>  
                                     ]);  
                                   var options = {  
                                   title: 'Percentage of Overall Quarantine & Covid-19 Patients',  
                                   //is3D:true,  
                                   pieHole: 0.4  
                                   };  
                                  var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                                  chart.draw(data, options);  
                                  }  
                         </script>  
                         <br>
                         <div style="width:230px;">
                            <div class="google" id="googleMap" style="width:230%;height:455px;"></div>
                            </div>     

                         <script>
                         function myMap() {
                           var mapProp= {
                           center:new google.maps.LatLng(4.21,101.9758),
                            zoom:8,};
                           var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);}
                         </script>

                         <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnDCRwzXzqtR7vZniE2bn1ICa56Ougsd0&callback=myMap"></script>
                           <div style="width:655px;">
                            <div class="margin" id="piechart" style="width: 655px; height: 450px;">  
                            </div>
                            </div> 
                          </div>
                <?php
                include('footer.php');
                ?>