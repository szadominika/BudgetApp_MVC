<?php
namespace App\Controllers;

/**
 * Authenticated base controller
 */

 abstract class Authenticated extends \Core\Controller {

    /**
     * Require user to be authenticate before giving access to all methods in the controler
     * 
     * @return void
     */
    protected function before(){

        $this->requireLogin();
    }
 }