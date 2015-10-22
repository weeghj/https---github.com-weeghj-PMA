<?php

session_start(); // start up your PHP session! 
$_SESSION['username'] = $_POST['username'];
$_SESSION['continue'] = 'false';
   
if(isset($_POST['username']) && isset($_POST['password'])){

    $remember = false;
    if(isset($_POST['remember'])) {
        if ($_POST['remember'] == 'true') {
            $remember = true;
        }
    }    
    
    $adServer = "ldap://EDDARD";
	
    $ldap = ldap_connect($adServer);
    $username = $_POST['username'];
    $password = $_POST['password'];

    $ldaprdn = 'XMART' . "\\" . $username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);


    if ($bind) {
        $filter="(sAMAccountName=$username)";
        $result = ldap_search($ldap,"dc=XMART,dc=SIDE",$filter);
        ldap_sort($ldap,$result,"sn");
        $info = ldap_get_entries($ldap, $result);
        for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)
                break;
            /*echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["mail"][0] .")</p>\n";
            echo '<pre>';
            var_dump($info);
            echo '</pre>';
            $userDn = $info[$i]["distinguishedname"][0];  */
            //$_SESSION['fullname'] = $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0];
            $_SESSION['fullname'] = $info[$i]["name"][0];
            $_SESSION['image'] = $info[$i]["thumbnailphoto"][0];
            if($remember == true) {
                setcookie('username', $username, time() + (86400 * 30), "/");
                setcookie('password', $password, time() + (86400 * 30), "/");
            }            
            $retValue = "true";
            $_SESSION['continue'] = 'true';
            echo $retValue;
        }
        @ldap_close($ldap);
    } else {
        $retValue = "Invalid email address / password";
        echo $retValue;
    }
}
?>