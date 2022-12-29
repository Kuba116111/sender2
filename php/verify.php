<?php
    session_start();

    $rand = '';
    // $return = '';
    // if($return=='')
    // {
    //     $_SESSION['return'] = $return;
    //     // echo $_SESSION['return'];
    //     echo $_SESSION['return'].$return;
    // }else{
    //     $return = $_SESSION['return'];
    //     echo $_SESSION['return'].$return;
    // }

    if(isset($_POST['verifycode'])) {
        $verifycode = $_POST['verifycode'];
        weryfikacja('', '', 'codefrompage', '');
    }else{
        $verifycode = '';
    }

    function weryfikacja($email, $temat, $status, $return)
    {
        // header("Location: ../chat.php");
        global $rand, $verifycode;
        if($status=='verify'){
            $_SESSION['return'] = $return;
            $rand=rand(1000, 9999);
            $_SESSION['code'] = $rand;
            $tresc = 'To twój kod weryfikacyjny: '.$rand;
            // $tresc = 'W celu weryfikacji kliknij tutaj:http://localhost/strony/sender2/verify?verify='.$rand;
            mail($email, $temat, $tresc, "From: sender2@vp.pl");
            header("Location: ../verify.php");
            // if(weryfikacja2($rand)==true)
            // {
                //     return true;
                //     header("Location: test.php");
                // }
        }elseif ($status=='codefrompage') {
            $return = $_SESSION['return'];
            if($verifycode==$_SESSION['code'])
            {
                // echo $return; 
                $_SESSION['verify'] = true;
                unset($_SESSION['verifyerror']);
                header("Location: $return");
                // require_once($return);
                // verify();
            }else{
                echo "Błąd";
                // header("Location: ../verify");
                header("Location: ../verify");
                $_SESSION['verifyerror'] = '<p class="error">Błędny kod weryfikacyjny';
                echo $verifycode.$_SESSION['code'];
            }
            // echo $_SESSION['return'].$return;
        }
    }

    // function weryfikacja2($verify)
    // {
    //     global $rand;
    //     if ($rand==$verify) {
    //         return true;
    //         exit();
    //     }
    // }

?>