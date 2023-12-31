<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
/**
 * Profile controller
 */

 class Profile extends Authenticated {

    /**
     * Show the profile
     * 
     * @return void
     */
    public function showAction(){

        View::renderTemplate('Profile/show.html', [
            'user'=>Auth::getUser()

        ]);

    }

     /**
     * Show the form for editing the profile
     *
     * @return void
     */
    public function editAction()
    {
        View::renderTemplate('Profile/edit.html', [
            'user'=>Auth::getUser()
        ]);
    }

    /**
     * Update the profile
     *
     * @return void
     */
    public function updateAction()
    {

        $user=Auth::getUser();
        if ($user->updateProfile($_POST)) {

            Flash::addMessage('Changes saved');

            $this->redirect('/profile/show');

        } else {

            View::renderTemplate('Profile/edit.html', [
                'user' => $user
            ]);

        }
    }
 }