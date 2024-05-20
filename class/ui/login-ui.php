<?php

date_default_timezone_set('Asia/Jakarta');
class LoginUI{

    private $db = null;
    private $view = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles/login-style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <title>Login Page</title>
        </head>
        <body>
            <div class="container">
                <div class="login-box-left">
                    <div class="login-title">Drone<br>Checking System</div>
                    <form class="login-container" method="POST">
                        <div class="login-statement">Login to Your Account</div>
                        <div class="label-input-container">
                            <label class="label-input">Username</label>
                            <div class="container-input">
                                <i class='fa-solid fa-user fa-lg' style='color:#5D7C7E; margin-right:15px;'></i>
                                <input class="input-style" type="text" name="username" placeholder="example123">
                            </div>
                        </div>
                        <div class="label-input-container">
                            <label class="label-input">Password</label>
                            <div class="container-input">
                                <i class='fa-solid fa-lock fa-lg' style='color:#5D7C7E; margin-right:15px;'></i>
                                <input class="input-style" type="password" name="password" placeholder="**********">
                            </div>
                        </div>
                        <div><input class="login-button" type="submit" value="Log In"></div>
                    </form>
                    <div class="register-link">
                        Don't have account? <span><a href="index.php?view=register">Register here</a></span> 
                    </div>
                </div>
                <div class="login-box-right">
                    <img class="login-image" src="asset/main-image.jpg" alt="">
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
        $this->login();
    }

    private function validateForm($username, $password){
        if ($username == '' || $password == '') {
            return 'Please fill all data';
        }
        return 'success';
    }
    private function login(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $verified = $this->validateForm($username, $password);
            $userEncode = base64_encode($username);
            $passwordHash = hash("sha512", $password);
            // $currTime = hash("sha512", getDate()['hour']);
            if($verified == 'success'){
                $validated = $this->db->validateLogin($username, $passwordHash);
                if($validated == "success"){
                    header("Location: index.php?view=dashboard&user=$userEncode&query=&delete=");
                    exit;
                }
            }
            echo "<script>alert('$verified');</script>"; 
            return false;
        }
    }

    

}