<?php
/*
    This project was created following this turtorial: https://www.youtube.com/watch?v=yXzWfZ4N4xU.S

    This webpage has several input points for a form. In order to add form validation we use Bootstrap (CSS framework for responsive web pages).
    
    1. first add link to Bootstrap stylesheet document 
    2. create the website layout
    2.1 add rows as divs
    2.2 add column inside each row as divs
    2.3 add labels, input field to each row
    2.4 add a button
    3.get values from $_POST
    4. create a function that modifies string values to be safe from "xss attacks". stipslashes() and htmlspecialchars()

    5.Validation
    5.1 create errors array 
    5.2 if some condition, then add key-value pair to array ($fieldName => $errorType)
    5.3 Using Bootstrap special classes add messages under the form field during validation  
        (if <input class="is-invalid">  =>  <div class="invalid-feedback">) 


    
*/
define('REQUIRED_FIELD_ERROR', 'This field must be filled');

$errors = [
    'username' => '',
    'email' => '',
    'password' => '',
    'password_confirm' => '',
    'cv_url' => '',
];

$username = '';
$email = '';
$password = '';
$password_confirm = '';
$cv_url = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    function post_data($field)
    {
        $_POST[$field] ??= '';

        return htmlspecialchars(stripslashes($_POST[$field]));
    }

    $username = post_data('username');
    $email = post_data('email');
    $password = post_data('password');
    $password_confirm = post_data('password_confirm');
    $cv_url = post_data('cv_url');
    
    if (!$username){
        $errors['username'] = REQUIRED_FIELD_ERROR;
    } elseif (strlen($username) < 6 || strlen($username) > 16){
        $errors['username'] = "Username must be min 6, max 16 char";
    }

    if (!$email){
        $errors['email'] = REQUIRED_FIELD_ERROR;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'This field must be a valid email adress';
    }

    if (!$password){
        $errors['password'] = REQUIRED_FIELD_ERROR;
    }

    if (!$password_confirm){
        $errors['password_confirm'] = REQUIRED_FIELD_ERROR;
    }

    if ($password && $password_confirm && strcmp($password, $password_confirm) !==0){
        $errors['password_confirm'] = 'The passwords are not the same';
    }

    if (!$cv_url){
        $errors['cv_url'] = REQUIRED_FIELD_ERROR;
    } elseif ((!filter_var($cv_url, FILTER_VALIDATE_URL))){
        $errors['cv_url'] = 'This field must be a valid url adress';
    }
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="padding: 50px;">
    <form action="success.html" method="POST" novalidate>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Username</label>
                    <input class="form-control <?= $errors['username'] ? 'is-invalid' : '' ?>" name="username" type="text" value="<?= $username ?>">
                    <small class="form-text text-muted">Min:6 and max 16 characters</small>
                    <div class="invalid-feedback">
                        <?= $errors['username'] ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Email</label>
                    <input class="form-control <?= $errors['email'] ? 'is-invalid' : '' ?>" name="email" type="email" value="<?= $email ?>">
                    <div class="invalid-feedback">
                        <?= $errors['email'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Password</label>
                    <input class="form-control <?= $errors['password'] ? 'is-invalid' : '' ?>" name="password" type="password" value="<?= $password ?>">
                    <div class="invalid-feedback">
                        <?= $errors['password'] ?>
                    </div>
                </div>
                
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Repeat Password</label>
                    <input class="form-control <?= $errors['password_confirm'] ? 'is-invalid' : '' ?>" name="password_confirm" type="password" value="<?= $password_confirm ?>">
                    <div class="invalid-feedback">
                        <?= $errors['password_confirm'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">Your CV link</label>
            <input class="form-control <?= $errors['cv_url'] ? 'is-invalid' : '' ?>" name="cv_url" type="text" value="<?= $cv_url ?>"
                    placeholder="https://www.example.com/my-cv">
            <div class="invalid-feedback">
                <?= $errors['cv_url'] ?>
            </div>
        </div>
        <button class="btn btn-primary">Register</button>
    </form>
</body>
</html>