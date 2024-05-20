<?php
class RegisterUI{

    private $db = null;
    private $view = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles/register-style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <title>Register Page</title>
        </head>
        <body>
            <div class="container">
                <div class="register-box-left">
                    <div class="register-title">Drone<br>Checking System</div>
                        <form class="register-container" method="POST">
                        <div class="register-statement ">Register Your Account</div>
                        <div class="label-register-container">
                            <label class="label-register">Email</label>
                            <div class="container-register">
                                <i class='fa-solid fa-user fa-lg' style='color:#5D7C7E; margin-right:15px;'></i>
                                <input class="register-style" type="text" name="email" placeholder="example123@gmail.com">
                            </div>
                        </div>
                        <div class="label-register-container">
                            <label class="label-register">Username</label>
                            <div class="container-register">
                                <i class='fa-solid fa-user fa-lg' style='color:#5D7C7E; margin-right:15px;'></i>
                                <input class="register-style" type="text" name="username" placeholder="example123">
                            </div>
                        </div>
                        <div class="label-register-container">
                            <label for="" class="label-register">Password</label>
                            <div class="container-register">
                                <i class='fa-solid fa-lock fa-lg' style='color:#5D7C7E; margin-right:15px;'></i>
                                <input class="register-style" type="password" name="password" placeholder="**********">
                            </div>
                        </div>
                        <div class="label-register-container">
                            <label for="" class="label-register">Confirm Password</label>
                            <div class="container-register">
                                <i class='fa-solid fa-lock fa-lg' style='color:#5D7C7E; margin-right:15px;'></i>
                                <input class="register-style" type="password" name="confirmPassword" placeholder="**********">
                            </div>
                        </div>
                        <div><input class="register-button" type="submit" value="Register"></div>
                        <div class="login-link">
                            Already Have An Account? <span><a href="index.php?view=login">Login here</a></span> 
                        </div>
                    </form>
                </div>

                <div class="register-box-right">
                    <img class="register-image" src="asset/main-image.jpg" alt="">
                </div>
                
            </div>
        </body>
        </html>
    HTML;

    public function __construct($db){
        $this->db = $db;
    }

    public function getView(){
        echo $this->view;
        $this->register();
    }

    private function validateForm($email, $username, $password, $confirmPassword){
        if ($email == '' || $username == '' || $password == '' || $confirmPassword == '') {
            return "Please fill all data"; 
        }
        else if ($password !== $confirmPassword){
            return "Password and confirm password is not match";
        }
        return 'success';
    }
    private function register(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
            $verified = $this->validateForm($email, $username, $password, $confirmPassword);
            if($verified == 'success'){
                $passwordHash = hash("sha512", $password);  
                $isUnique = $this->db->validateUnique($username);
                if($isUnique == 'unique'){
                    $successRegist = $this->db->registUser($email, $username, $passwordHash);
                    if ($successRegist) {
                        header("Location: index.php?view=login");
                        exit;
                    }
                }
                echo "<script>alert('$isUnique');</script>"; 
                return false;
            }
            echo "<script>alert('$verified');</script>"; 
        } 
    }
}