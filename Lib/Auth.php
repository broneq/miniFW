<?php

namespace MiniFw\Lib;

/**
 * Class Auth
 * @package MiniFw\Lib
 */
class Auth
{
    private $users = [];
    /**
     * @var string
     */
    private $realm;

    /**
     * Auth constructor.
     * @param string $realm
     */
    public function __construct(string $realm = 'Authorization request')
    {
        $this->realm = $realm;
    }

    /**
     * Adds an user
     * @param string $username
     * @param string $sha1Password
     */
    public function addUser(string $username, string $sha1Password): void
    {
        $this->users[$username] = $sha1Password;
    }

    /**
     * Request for authorization
     */
    public function authRequest(): void
    {
        if ($_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? false) {
            list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_SERVER['REDIRECT_HTTP_AUTHORIZATION'], 6)));
        }

        $user = $_SERVER['PHP_AUTH_USER'] ?? null;
        $pass = $_SERVER['PHP_AUTH_PW'] ?? null;

        $validated = (in_array($user, array_keys($this->users))) && (sha1($pass) == $this->users[$user]);

        if (!$validated) {
            header('WWW-Authenticate: Basic realm="' . $this->realm . '"');
            header('HTTP/1.0 401 Unauthorized');
            $this->unathorized();
        }
    }

    /**
     * Unathorized action
     */
    private function unathorized(): void
    {
        die('Unathorized');
    }
}