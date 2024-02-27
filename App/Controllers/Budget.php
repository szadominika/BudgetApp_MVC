<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use App\Models\UsersExpense;
use App\Models\UsersIncome;

/**
 * Budget controller
 */
class Budget extends Authenticated
{
	public $users_expense;
	public $users_income;
	/**
	 * Before filter - called before each action method
	 *
	 * @return void
	 */
	protected function before()
	{
		parent::before();
		
		$this->users_expense = new UsersExpense();
		$this->users_income = new UsersIncome();
	}
	
	/**
	 * Show the view balance
	 *
	 * @return void
	 */
	public function viewAction()
	{	
		View::renderTemplate('Budget/view.html');
	}
	

}
