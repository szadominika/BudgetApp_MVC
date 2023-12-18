<?php
namespace App\Controllers;
use \Core\View;
use \App\Auth;

/**
 * Restrict the page to logged-in users only
 */

 class Restrict extends Authenticated {

    /**
     * Restrict index
     * 
     * @return void
     */
    public function indexAction()    {

        View::renderTemplate('Restrict/index.html');
    }

    /**
     * Add new item
     * 
     * @return void
     */
    public function newAction()    {
        
        echo "new action";
    }

 }