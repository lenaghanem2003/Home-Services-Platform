<?php
require "config.php";

 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
    $email="";
    $password="";
    

    
    if(isset($_POST['email'])){
        $email=$_POST['email'];
    }
    if(isset($_POST['password'])){
        $password=$_POST['password'];
    }


    $action=$db->prepare("SELECT User_ID, User_Name, Password ,Role_ID FROM Account WHERE Email = ?");
    $action->bind_param("s",$email);
    $action->execute();
    $result=$action->get_result();
    

    

    if($result->num_rows>0){
        $array_row=$result->fetch_assoc();
        

    if(password_verify($password, $array_row['Password'])){
        $_SESSION['user_id'] = $array_row['User_ID'];
        $_SESSION['role_id'] = $array_row['Role_ID'];
        $_SESSION['name']= $array_row['User_Name'];
        $_SESSION['status_message']="sucsses";
        $_SESSION['message']='welcome back  '.$array_row['User_Name'];
        $flage=1;

        if($array_row['Role_ID']===1){
            header("Location:homePage.php");
            exit();

        }else if($array_row['Role_ID']===2){
            header("location:dashboardProvider.php");
            exit();

        }else{
            header("location:admin.php");
            exit();
        }
            
            
    }else{
        $_SESSION['status_message']="fail";
        $_SESSION['message']="Check your password";
        header("Location:loginPage.php");
            exit();
    }
    
    }else {
        $_SESSION['status_message']="fail";
        $_SESSION['message']="Check your email";
        header("Location:loginPage.php");
            exit();
    }


    
 }
?>