<?php

namespace Blog\Controllers;

/**
 * Class SessionController
 * @package Blog\Controller
 */
class SessionController
{
    /**
     * @var mixed
     */
    private $session;

    /**
     * @var
     */
    private $user;

    /**
     * SessionController constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);
        if (isset($this->session['user'])) {
            $this->user = $this->session['user'];
        }
    }

    /**
     * @param int $idUser
     * @param string $username
     * @param string $email
     */
    public function createSession(int $Uid, string $pseudo, string $email, string $role)
    {
        $_SESSION['user'] = [
            'id' => $Uid,
            'username' => $pseudo,
            'email' => $email,
            'role' => $role,
        ];
    }

    /**
     * @return void
     */
    public function destroySession()
    {
        $_SESSION['user'] = [];
        session_destroy();
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('user', $this->session)) {
            if (!empty($this->user)) {

                return true;
            }
        }
        return false;
    }

    /**
     * @param $var
     * @return mixed
     */
    public function getUserVar($var)
    {
        if ($this->isLogged() === false) {

            return null;
        }
        return $this->user[$var];
    }

    /**
     * @return bool
     */
    public function checkAdmin()
    {
        if ($this->isLogged()) {
            if ($this->getUserVar('role') === '1') {

                return true;
            }
            $this->destroySession();
        }
        return false;
    }
}