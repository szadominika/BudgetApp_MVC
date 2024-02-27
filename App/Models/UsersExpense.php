<?php

namespace App\Models;

use \App\Auth;
use PDO;

/**
 * User's expense model
 */
class UsersExpense extends \Core\Model
{
	public $user_id;
	public $amount;
	public $date_of_expense;
	public $expense_category;
	public $comment;
	public $category_id;
	public $payment_category;
	public $payment_method_id;
	public $expense_category_id;

	/**
     * Class constructor
	 *
     * @return void
     */
    public function __construct()
    {
		$user = Auth::getUser();
		$this->user_id = $user->id;
    }
	
	/**
	 * Get expenses categories assigned to user
	 *
	 * @return array Users expenses categories
	 */
	public function getExpensesCategories()
	{
		$sql = 'SELECT name FROM expenses_category_assigned_to_users WHERE user_id = :user_id';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();
	}

		/**
	 * Get methods payments assigned to user
	 *
	 * @return array Users methods payments categories
	 */
	public function getMethodPayments()
	{
		$sql = 'SELECT name FROM payment_methods_assigned_to_users WHERE user_id = :user_id';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();
	}

	/**
     * add expense to specified user
     *
     * @param array $data Data from the add expense form
     *
     * @return boolean  True if the data was updated, false otherwise
     */
    public function addExpense($data)
    {
		if (isset($data['amount'])) {
			$this->amount = $data['amount'];
			$this->date_of_expense = $data['date_of_expense'];
			$this->payment_category = $data['payment_category'];
			$this->expense_category = $data['expense_category'];
			$this->comment = $data['comment'];
			
			$this->payment_method_id = $this->findPaymentIdByName();
			$this->expense_category_id = $this->findExpenseCategoryIdByName();
			
			$sql = 'INSERT INTO expenses VALUES (NULL, :user_id, :expense_category_id, :payment_method_assign_to_user_id, :amount, :date_of_expense, :comment)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

			$stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
			$stmt->bindValue(':expense_category_id', $this->expense_category_id, PDO::PARAM_INT);
			$stmt->bindValue(':payment_method_assign_to_user_id', $this->payment_method_id, PDO::PARAM_STR);
			$stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
			$stmt->bindValue(':date_of_expense', $this->date_of_expense, PDO::PARAM_STR);
			$stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

	/**
     * Find id category by its name
     *
     * @return integer Id income category assigned to user
     */
    protected function findIdByCategoryName()
    {
		$sql = 'SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :expense_category';
		
		$db = static::getDB();
        $stmt = $db->prepare($sql);
		
		$stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$stmt->bindValue(':expense_category', $this->expense_category, PDO::PARAM_STR);
		$stmt->execute();
		
		$categoryId = $stmt->fetch();
		
		return $categoryId['id'];
	}

		/**
     * Find payment method id by its name
     *
     * @return integer Id payment method assigned to user
     */
    protected function findPaymentIdByName()
    {
		$sql = 'SELECT id FROM payment_methods_assigned_to_users WHERE user_id = :user_id AND name = :payment_category';
		
		$db = static::getDB();
        $stmt = $db->prepare($sql);
		
		$stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$stmt->bindValue(':payment_category', $this->payment_category, PDO::PARAM_STR);
		$stmt->execute();
		
		$paymentId = $stmt->fetch();
		
		return $paymentId['id'];
	}
	
	/**
     * Find expense category id by its name
     *
     * @return integer Id expense category assigned to user
     */
    protected function findExpenseCategoryIdByName()
    {
		$sql = 'SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :expense_category';
		
		$db = static::getDB();
        $stmt = $db->prepare($sql);
		
		$stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$stmt->bindValue(':expense_category', $this->expense_category, PDO::PARAM_STR);
		$stmt->execute();
		
		$categoryId = $stmt->fetch();
		
		return $categoryId['id'];
	}

}
