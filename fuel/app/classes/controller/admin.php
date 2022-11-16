<?php

namespace Controller;

class Admin extends \Controller_template {

    public function before()
    {
        parent::before();

        \Asset::add_path('assets/fonts', 'fonts'); // Register a new path to find font files

        $this->template->header = \View::forge('partials/header');
        $this->template->footer = \View::forge('partials/footer');
    }

}
