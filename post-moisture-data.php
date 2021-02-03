<html>
    <body>
        <?php
            include("database_connection.php");

            if(!$connect){
                echo "Cannot connect to the Database";
                exit();
            }
            
            $api_key_value = "tPmAT5Ab3j7F9";

            $api_key = $moisture = "";

            $api_key = $_GET["api_key"];

            if($api_key == $api_key_value) {
                $moisture = $_GET["moisture"];
                
                $sql = "INSERT INTO sensordata (moisture) VALUES ('" . $moisture . "')";

                $res = pg_query($connect,$sql);

                if ($res) {
                    header("Location: https://automatic-irrigation-system.herokuapp.com");
                } 
            
                pg_close($connect);
            }
            else {
                echo "Wrong API Key provided.";
            }
        ?>
    </body>
</html>

