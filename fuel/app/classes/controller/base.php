<?php

namespace Controller;

class Base extends \Controller_template {

    public function before()
    {
        parent::before();

        $this->template->header = \View::forge('partials/header');
        $this->template->footer = \View::forge('partials/footer');
    }

}
