<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\User;
use App\Models\UsersIncome;
/**
 * Profile controller
 */

 class Profile extends Authenticated {

        /**
     * User object returned from Auth class
     * @var user 
     * 
     */
    public $user;



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

    /**
     * Delete the account
     * 
     * @return void
     * 
     */
    public function deleteAction() {
        $this -> user = Auth::getUser();
        if ($this->user->deleteUser($_POST)) {

            Flash::addMessage('Account deleted successfully');

            $this -> redirect('/');

        } //else {

            //View::renderTemplate('Settings/show.html', [
                //'user' => $this -> user,
                //'currentIncomeCategories' => $this -> incomeCategories,
                //'currentExpenseCategories' => $this -> expenseCategories,
                //'currentPaymentMethods' => $this -> paymentMethods
           // ]);

        //}
    }
 }