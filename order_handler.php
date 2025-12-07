<?php

session_start();

if (empty($_SESSION['cart'])) {
    header('Location: view_cart.php');
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'order')
{

    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $name = trim(htmlspecialchars($_POST['name'] ?? ''));
    $surname = trim(htmlspecialchars($_POST['surname'] ?? ''));
    $streetName = trim(htmlspecialchars($_POST['streetName'] ?? ''));
    $streetNum = trim(htmlspecialchars($_POST['streetNum'] ?? ''));
    $city = trim(htmlspecialchars($_POST['city'] ?? ''));
    $postcode = trim(htmlspecialchars($_POST['postcode'] ?? ''));
    $phoneNum = trim(htmlspecialchars($_POST['phoneNum'] ?? ''));
    $soulAgreement = htmlspecialchars($_POST['soulAgreement'] ?? '');
    $correct = true;

    $required_fields = [
        'email' => $email,
        'name' => $name,
        'surname' => $surname,
        'streetName' => $streetName,
        'city' => $city,
        'postcode' => $postcode,
        'phoneNum' => $phoneNum
    ];

    foreach ($required_fields as $field_name => $field_value) {
        if (empty($field_value)) {
            var_dump($field_value);
            $correct = false;
        }
    }


    //Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $correct = false;
    }

    // Společný regex pro jméno a příjmění
    $name_pattern = "/^[a-zA-ZŠČŘŽĎňťěščřžýáíéúůÓÚÁÉĚÍÝ' \-.]+$/u";

    // Jméno
    if (!preg_match($name_pattern, $name)) {
        $correct = false;
    }
    // Příjmění
    if (!preg_match($name_pattern, $surname)) {
        $correct = false;
    }

    // Název ulice
    if (!preg_match('/^[a-zA-ZŠČŘŽĎňťěščřžýáíéúůÓÚÁÉĚÍÝ\s\-]*$/u', $streetName)) {
        $correct = false;
    }

    // Číslo ulice
    if (!preg_match('/^\d+([\/ ]*[a-zA-Z])?$/', $streetNum)) {
        $correct = false;
    }

    // Město
    if(!preg_match('/^[a-zA-ZŠČŘŽĎňťěščřžýáíéúůÓÚÁÉĚÍÝ\' \-.]+$/u', $city)) {
        $correct = false;
    }

    // PSČ
    if (!preg_match('/^([0-9]{5}|[0-9]{3} [0-9]{2})$/', $postcode)) {
        $correct = false;
    }

    // Telefonní číslo
    if (!preg_match('/^\+?[\d\s]{9,20}$/', $phoneNum)) {
        $correct = false;
    }

    // Souhlas
    if ($soulAgreement !== 'on') {
        $correct = false;
    }

//    var_dump($_POST);

    if($correct){
        session_unset();
        header('Location: index.php');
    }
    else
    {
        header('Location: view_cart.php');
    }
    die();



//    $email = htmlspecialchars($_POST['email']);
//
//    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//        // Email is NOT syntactically valid
//        var_dump($email);
//        $correct = false;
//    }
//
////    $pattern = "/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/";
////    var_dump(preg_match($pattern, $email));
//
//    $name_pattern = "/^[A-ZŠČŘŽĎ'][a-zA-ZŠČŘŽĎďěščřžýáíé\-']*$/";
//
//    $name = htmlspecialchars($_POST["name"]);
//    if (!preg_match($name_pattern,$name)) {
//        var_dump($name);
//        $correct = false;
//    }
//
//
//
//    $surname = htmlspecialchars($_POST['surname']);
//
//    if (!preg_match($name_pattern,$surname)) {
//        var_dump($surname);
//        $correct = false;
//    }
//
//    $streetName = htmlspecialchars($_POST['streetName']);
//    $streetNum = htmlspecialchars($_POST['streetNum']);
//
//    if (!preg_match('/^[A-ZŠČŘŽĎŇŤ][a-záéěíóúůýA-ZŠČŘŽĎŇŤÚ. ]*$/', $streetName)) {
//        var_dump($streetName);
//        $correct = false;
//    }
//    if (!preg_match('//', $streetNum)) {
//        var_dump($streetNum);
//        $correct = false;
//    }
//
//
//    $city = htmlspecialchars($_POST['city']);
//    if(!preg_match('/^[A-ZŠČŘŽĎ\'][ a-zA-ZŠČŘŽĎďňěščřžýáíé\-\']*$/', $city)) {
//        var_dump($city);
//        $correct = false;
//    }
//
//
//    $postcode = htmlspecialchars($_POST['postcode']);
//    if (!preg_match('/^([0-9]{5}|[0-9]{3} [0-9]{2})$/', $postcode)) {
//        var_dump($postcode);
//        $correct = false;
//    }
//
//
//    $phoneNum = htmlspecialchars($_POST['phoneNum']);
//    if (!preg_match('/^\+?[\d\s]{9,20}$/', $phoneNum)) {
//        var_dump($phoneNum);
//        $correct = false;
//    }
//
//    $soulAgreement = htmlspecialchars($_POST['soulAgreement']);
//    if  (!$soulAgreement == 'on') {
//        var_dump($soulAgreement);
//    }


}

