
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

            function isMail($email){
                 
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
                return true;
            }

            $error = array();
            $data = array();
            if(!empty($_POST['action_forgotpassword'])){
                $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
                $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
                $data['newpassword'] = isset($_POST['newpassword']) ? $_POST['newpassword'] : '';
                $data['newpasswordconf'] = isset($_POST['newpasswordconf']) ? $_POST['newpasswordconf'] : '';
                
                if (empty($data['email'])){
                    $error['email'] = 'Ban chua nhap Email';
                }
                elseif(!isMail($data['email'])){
                    $error['email'] ='Email sai dinh dang';
                }
                if (empty($data['username'])){
                    $error['username'] = 'Ban chua nhap user name';
                }
                elseif(strlen($data['username'])<6){
                    $error['password'] ='Mat khau it hon 6 ki tu';
                }
                
                if (empty($data['newpassword'])){
                    $error['newpassword'] = 'Bạn chua nhap mat khau moi';
                }
                elseif(strlen($data['newpassword'])<8){
                    $error['newpassword'] ='Mat khau it hon 8 ki tu';
                }
                if (empty($data['newpasswordconf'])){
                    $error['newpasswordconf'] = 'Bạn chua nhap lai mat khau moi';
                }
                elseif(strcmp($data['newpassword'],$data['newpasswordconf'])!=0){
                    $error['newpasswordconf'] = '2 mat khau khac nhau';
                }
                
                if (!$error){
                    require('./connectdb.php');
                    $stmt = $conn->prepare("SELECT * FROM Users WHERE email ='".$data['email']."'");
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();
                    if($stmt->rowCount()!=1){
                        echo 'email nguoi dung khong ton tai';
                    }
                    else{
                        $stmt1 = $conn->prepare("SELECT * FROM Users WHERE username ='".$data['username']."'");
                        $stmt1->setFetchMode(PDO::FETCH_ASSOC); 
                        $stmt1->execute();
                          
                        if($stmt1->rowCount()!=1){
                            echo 'Ten dang nhap khong ton tai';
                        }
                        else{
                            $stmt2 = $conn->prepare("SELECT * FROM Users WHERE password ='".$data['newpassword']."'");
                            $stmt2->setFetchMode(PDO::FETCH_ASSOC); 
                            $stmt2->execute();
                            if($stmt2->rowCount()==1){
                                echo 'mat khau khong hop le';
                            }
                            else{
                                $sql = "UPDATE Users SET password=?  WHERE email=?";
                                $conn->prepare($sql)->execute([$data['newpassword'],$data['email']]);
                                 header("Location: ./");
                                 exit;
                            }
                        }
                        
                    }
                   
                }
                else{
                    echo 'Doi mat khau that bai';
                }
            }
           
            
    ?>
    <form id="basic-form"  name="myform" action="forgotpassword.php" method="post" >
      
            <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Forgot Password</h1>
            <input  name="email" id="inputEmail" placeholder="Email">
            <br>
            <?php echo isset($error['email']) ? $error['email'] : ''; ?>
            <br>    
            <input type="username" name="username" id="inputUsername" placeholder="Ten dang nhap">
            <br>
            <?php echo isset($error['username']) ? $error['username'] : ''; ?>
            <br> 
            <input type="newpassword" name="newpassword" id="inputNewPassword" placeholder="Mat khau moi">
            <br>
            <?php echo isset($error['newpassword']) ? $error['newpassword'] : ''; ?>
            <br>
            <input type="newpasswordconf" name="newpasswordconf" id="inputNewPasswordconf" placeholder=" Nhap lai mat khau moi">
            <br>
            <?php echo isset($error['newpasswordconf']) ? $error['newpasswordconf'] : ''; ?>
            <br>
            <td><input type="submit" name="action_forgotpassword" value="Doi mat khau"/></td>
            <p class="mt-5 mb-3 text-muted">© 2021-2022</p>
         
      </form>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
      
</body>
</html>