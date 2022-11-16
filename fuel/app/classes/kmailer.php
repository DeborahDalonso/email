<?php

class KMailer extends PHPMailer\PHPMailer\PHPMailer {

    protected $config = array();

    public function __construct($exceptions = false)
    {
        parent::__construct($exceptions);

        \Config::load('kmailer', true);

        $this->config = \Config::get('kmailer.defaults');
        $this->_init();
    }

    protected function _init()
    {
        foreach ($this->config as $key => $val) {
            if (method_exists($this, 'set' . \Inflector::camelize($key))) {
                $method = 'set' . \Inflector::camelize($key);
                $this->$method($val);
            }
        }
        
    }

    public function setHost($host)
    {
        $this->Host = $host;
        return $this;
    }

    public function setUserName($username)
    {
        $this->Username = $username;
        return $this;
    }

    public function setPassword($password)
    {
        $this->Password = $password;
        return $this;
    }

    public function setPort($port)
    {
        $this->Port = $port;
    }

    protected function setCharset($charset)
    {
        $this->CharSet = $charset;

        return $this;
    }

    public function setIsHtml($isHtml)
    {
        $this->isHTML($isHtml);

        return $this;
    }

    public function setSecurity($security)
    {
        $this->SMTPSecure = $security;

        return $this;
    }

    public function setSmtpAuth($smtpAuth)
    {
        $this->SMTPAuth = $smtpAuth;
        return $this;
    }

    public function getUserName()
    {
        $username = $this->Username;
        return $username;
    }

}
