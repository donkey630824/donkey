<?php
    $conn = mysqli_connect("localhost", "root", "", "donkeydb");
    mysqli_set_charset($conn, 'utf8');
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    date_default_timezone_set("Asia/Bangkok");

    $id = $_GET['id'];

    $accept_date = date('Y-m-d');
    $accept_time = date('H:i:s');
    $accept_datetime = date('Y-m-d H:i:s');
    $sql = "UPDATE service SET accept_date='$accept_date', accept_time = '$accept_time', accept_datetime = '$accept_datetime' WHERE id='$id'";
    $result = mysqli_query($conn,$sql);
    if($result){
      $sql_wait = "SELECT sdate,stime,accept_datetime FROM service WHERE id='$id' ";
      $result_wait = mysqli_query($conn, $sql_wait);
      while($row_wait = mysqli_fetch_array($result_wait,MYSQLI_ASSOC)){
          $start_datetime = $row_wait['sdate'].' '.$row_wait['stime'];
          $end_datetime = $row_wait['accept_datetime'];
      }
    
    $date1 = strtotime($start_datetime);
    $date2 = strtotime($end_datetime);
    
    $diff = abs($date2 - $date1);
    
    $years = floor($diff / (365*60*60*24));
    
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));
    
    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
    
    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);
    
    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
    
    // printf("%d years, %d months, %d days, %d hours, ". "%d minutes, %d seconds", $years, $months, $days, $hours, $minutes, $seconds);
    
    $years == 0 ? $years = '' : $years = $years.' '.'ปี ';
    $months == 0 ? $months = '' : $months = $months.' '.'เดือน ';
    $days == 0 ? $days = '' : $days = $days.' '.'วัน ';
    $hours == 0 ? $hours = '' : $hours = $hours.' '.'ชั่วโมง ';
    $minutes == 0 ? $minutes = '' : $minutes = $minutes.' '.'นาที ';
    $seconds == 0 ? $seconds = '' : $seconds = $seconds.' '.'วินาที ';
    
    $waits = $years.$months.$days.$hours.$minutes.$seconds;
    echo $waits;echo '<br>';
        $sql_accept_wait = "UPDATE service SET 
                            accept_year ='$years', 
                            accept_month ='$months', 
                            accept_day ='$days', 
                            accept_hour = '$hours', 
                            accept_minute = '$minutes', 
                            accept_second = '$seconds', 
                            accept_wait = '$waits' 
                          WHERE id='$id'";
    echo $sql_accept_wait;                      
     $result_accept_wait = mysqli_query($conn,$sql_accept_wait);
        // if($result_accept_wait){
        //   echo '<script>';
        //   echo 'window.location.href = "memlist.php";';
        //   echo '</script>';
        //  }
    }else{
      print("มีข้อผิดพลาดในการปรับปรุงข้อมูล!:(");
    }
    mysqli_close($conn);
    ?>
    
    




