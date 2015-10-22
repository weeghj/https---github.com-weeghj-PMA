<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    /**
     * @var string of the user name
     */
    private $username;
    /**
     * @var string of the password
     */
    public $password;

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct($username, $password)
    {
        // create/read session, absolutely necessary
        session_start();

        // Set variables
        $this->username = $username;
        $this->password = $password;
    }


    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "You have been logged out.";

    }

    /**
     * simply check if it's a valid user
     * @return boolean
     */
    public function isUserVallid()
    {
        $adServer = "ldap://EDDARD";

        $ldap = ldap_connect($adServer);

        $ldaprdn = 'XMART' . "\\" . $username;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = @ldap_bind($ldap, $ldaprdn, $password);


        if ($bind) {
            @ldap_close($ldap);
            return true;
        } else {
            return false;
        }        
        return false;
    }
}
