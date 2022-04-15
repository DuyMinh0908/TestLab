<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="text-center" >
    <?php
            $error = array();
            $data = array();
            if(!empty($_POST['action_login'])){
                $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
                $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
                if (empty($data['username'])){
                    $error['username'] = 'Ban chua nhap user name';
                }
                elseif(strlen($data['username'])<6){
                    $error['password'] ='Mat khau it hon 6 ki tu';
                }
                
                if (empty($data['password'])){
                    $error['password'] = 'Bạn chua nhap mat khau';
                }
                elseif(strlen($data['password'])<8){
                    $error['password'] ='Mat khau it hon 8 ki tu';
                }
                
                if (!$error){
                    require('./connectdb.php');
                    $stmt = $conn->prepare("SELECT * FROM Users WHERE username ='".$data['username']."' and password ='".$data['password']."'");
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();
                    if($stmt->rowCount()!=1){
                        $stmt1 = $conn->prepare("SELECT * FROM Users WHERE username ='".$data['username']."'");
                        $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                        $stmt1->execute();                   
                        if($stmt1->rowCount()!=1){
                            echo 'Nguoi dung khong ton tai';
                        }
                        else{
                            echo 'Nhap sai mat khau';
                        }
                    }    
                    else{
                         $_SESSION["username"] = $data['username'];
                         header("Location: /info.php");
                         exit;
                    }
                   
                }
                else{
                    echo 'Dang nhap that bai';
                }
            }
           
            
    ?>
    <form id="basic-form"  name="myform" action="index.php" method="post" >
      
            <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <input type="username" name="username" id="inputUsername" placeholder="Ten dang nhap">
            <br>
            <?php echo isset($error['username']) ? $error['username'] : ''; ?>
            <br> 
            <input type="password" name="password" id="inputPassword" placeholder="Mat khau">
            <br>
            <?php echo isset($error['password']) ? $error['password'] : ''; ?>
            <br>
            <td><input type="submit" name="action_login" value="Dang nhap"/></td>
            <p class="mt-5 mb-3 text-muted">© 2021-2022</p>
         
      </form>
      <a href="forgotpassword.php">Quen mat khau ?</a>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
      
</body>
</html>