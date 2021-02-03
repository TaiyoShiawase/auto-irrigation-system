<?php include ('shared/header.php')?>
<?php 
  include("database_connection.php"); 

  if(!$connect){
      echo "Error: Cannot Connect to Database";
      exit();
  }
?>
<div class="body container-fluid p-0 bg-dark ">

  <div class = "  col-sm-12 py-3 mb-5 text-dark bg-light">
    <h2> <i class="fas fa-fill-drip text-primary ml-2 mr-3 mt-2" style="font-size: 30px"></i> SOIL / Automatic Irrigation System</h2>
  </div>
  
  <div class = "col-sm-10 col-md-8 col-lg-6 
    offset-sm-1 offset-md-2 offset-lg-3 bg-light
    border-0 rounded shadow pt-5 px-5 mb-5">

    <h3 class = "text-dark"> 
      <i class="fas fa-fill-drip"></i> Current Moisture
    </h3>

    <?php
          $sql = "SELECT moisture, reading_time FROM SensorData ORDER BY id DESC LIMIT 1"; 
          
          if($result = pg_query($connect,$sql)){
             $row = pg_fetch_row($result);
          }
    ?>      
          <h1 class="text-center text-primary mt-5"><?php echo $row[0]; ?><h1>
    
          <div class="mt-4">
            <p class="text-dark text-right mx-5" style="font-size: 15px">
              <i class="far fa-clock"></i> <?php echo $row[1];  ?>
            </p>
          </div>
    <hr>
    
    <div class="col-sm-12 mt-4 mb-5 text-center"> 
    <?php
      if($row[0] < 0){
        echo "<h4>Moisture Level is LOW, Watering Plants Now.</h4>";
      } 
    ?> 
    </div>
  </div>
</div>

<?php include ('shared/footer.php')?>