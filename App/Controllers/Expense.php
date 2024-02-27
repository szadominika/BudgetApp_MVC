<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use App\Models\UsersExpense;

/**
 * Expense controller
 *
 * PHP version 7.0
 */
class Expense extends Authenticated
{
	public $users_expense;
	/**
	 * Before filter - called before each action method
	 *
	 * @return void
	 */
	protected function before()
	{
		parent::before();
	
		$this->users_expense = new UsersExpense();
	}
	
	/**
	 * Show the add expense
	 *
	 * @return void
	 */
	public function addAction()
	{		
		$expense_categories = $this->users_expense->getExpensesCategories();
		$method_payments = $this->users_expense->getMethodPayments();
		
        View::renderTemplate('Expense/show.html', [
			'expense_categories' => $expense_categories,
			'method_payments' => $method_payments
		]);
    }
	
	/**
	 * Add expense to user
	 *
	 * @return void
	 */
	public function addExpenseAction()
	{
		if ($this->users_expense->addExpense($_POST)) {

			Flash::addMessage('Sucessfully added expense!');

		} 

		$this->redirect('/expense/add');
	}
}