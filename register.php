<?php
require "config.php";

$flage=0;
 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
    $username="";
    $email="";
    $password="";
    $role_id = 1;
    $phone_number="";
    $location="";

    if(isset($_POST['name'])){
        $username=$_POST['name'];
    }
    if(isset($_POST['email'])){
        $email=$_POST['email'];
    }
    if(isset($_POST['password'])){
        $password=$_POST['password'];
    }
    if(isset($_POST['number'])){
        $phone_number=$_POST['number'];
    }
    if(isset($_POST['location'])){
        $location=$_POST['location'];
    }

    $address_parts = explode(',', $location);

// توزيع البيانات وإعطاء قيم افتراضية في حال لم يدخل العميل تفاصيل كاملة
$governorate = isset($address_parts[0]) ? trim($address_parts[0]) : "";
$village     = isset($address_parts[1]) ? trim($address_parts[1]) : "";
$street      = isset($address_parts[2]) ? trim($address_parts[2]) : "";


    

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $split_name=preg_split('/[\s_-]+/',$username);
    $first_name=$split_name[0];
    $last_name = isset($split_name[1]) ? $split_name[1] : "";

    $action=$db->prepare("INSERT INTO Account (User_Name, Email, Password, Role_ID) VALUES (?, ?, ?, ?)");
    $action->bind_param("sssi", $username, $email, $hashed_password, $role_id);
    $succsess1=$action->execute();
    
    $user_id=$db->insert_id;
$action2 = $db->prepare("INSERT INTO customer (Phone_No, First_Name, Last_Name, Governorate, Village, Street, User_ID) VALUES (?,?,?,?,?,?,?)");
$action2->bind_param("ssssssi", $phone_number, $first_name, $last_name, $governorate, $village, $street, $user_id);
    $succsess2=$action2->execute();

    

    if($succsess1&& $succsess2){
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name']=$username;
    
    
        $_SESSION['email']=$email;
    
    
        $_SESSION['password']=$hashed_password;
    
    
        $_SESSION['number']=$phone_number;
    
    
        $_SESSION['location']=$location;

        $_SESSION['status_message']="sucsses";
        $_SESSION['message']='Account created successfully!\n Welcome ' .$username;
        

        header("location:homePage.php");

        exit();
        
        
    }else {
        $_SESSION['status_message']="fail";
        $_SESSION['message']='Registration failed. Please check your information and try again';
        header("location:loginPage.php");
        exit();
    }


    
 }
?>