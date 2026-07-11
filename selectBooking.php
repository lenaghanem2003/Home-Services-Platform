<?php
require "config.php";
    
    $status="";
    if(isset($_GET['status'])){
        $status=$_GET['status'];
    }else{
        $status="all";
    }

    $sql="SELECT 
    b.Booking_ID, 
    b.Booking_Time, 
    b.Booking_Date, 
    b.status,
    s.Service_Name, 
    p.First_Name, 
    p.Last_Name,
    p.Phone_No,
    b.Provider_ID,
    b.Service_ID
    FROM Booking b
    JOIN service s ON b.Service_ID = s.Service_ID
    JOIN Provider p ON b.Provider_ID = p.Provider_ID 
    WHERE b.Customer_ID = (SELECT Customer_ID FROM customer WHERE User_ID = ?)";

        

        if($status !== 'all'){
            $sql .=" AND b.status =?";
        }

        $sql .= " ORDER BY b.booking_date DESC";//لحتى يعطيني التواريخ الحديثة أول 

        $stmt=$db->prepare($sql);
        

        $customer_id = $_SESSION['user_id'];

        if ($status !== 'all') {
            $stmt->bind_param("is", $customer_id, $status);
        } else {
            $stmt->bind_param("i", $customer_id);
        }

        $stmt->execute();
        $result=$stmt->get_result();

        $bookings =[];
        while($row = $result->fetch_assoc()){
            // وقت الحفظ (raw) يبقى كما هو في Booking_Time
                $row['Booking_Time_Display'] = date('h:i A', strtotime($row['Booking_Time'])); // للعرض فقط
                $bookings[] = $row;
        }   
            


        header('Content-Type: application/json');
        echo json_encode($bookings);
        exit;



?>
