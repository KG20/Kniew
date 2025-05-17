<?php
/**
*
*/
class Payment extends Model
{
	function __construct()
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_NUM;
		$this->_table = 'professional';
		parent::__construct();
	}

	public function paidForDonation($donationid, $orderid, $paymentid,$paidto)
	{

		$query = "UPDATE " . DB_SCHEMA .".donation SET paymentid = :paymentid WHERE orderid = :orderid AND donationid = :donationid AND paymentid IS NULL AND paidby = :paidby and paidto = :paidto returning paymentid;";
		$this->_bind = array(
			':paymentid' => $paymentid,
			':paidby' => $_SESSION['id'],
			':paidto' => $paidto,
			':orderid' => $orderid,
			':donationid' => $donationid
		 );
		$result = $this->custom($query);
		return $result[0];
	}

	public function paidForMessage($threadid, $orderid, $paymentid)
	{

		$query = "UPDATE " . DB_SCHEMA .".messagethread SET paymentid = :paymentid, paidby=:paidby WHERE orderid = :orderid AND threadid = :threadid AND paymentid IS NULL returning paymentid;";
		$this->_bind = array(
			':paymentid' => $paymentid,
			':paidby' => $_SESSION['id'],
			':orderid' => $orderid,
			':threadid' => $threadid
		 );
		$result = $this->custom($query);
		return $result[0];
	}

	public function addRPAccountId($accountid)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA .".professional set linkedaccountid = :linkedaccountid where id = :id;";
		$this->_bind = array(':linkedaccountid' => $accountid, ':id' => $_SESSION['id'] );
		$result = $this->custom($query);
		return $result;
	}

	public function insertpaymentid($id, $subscriptionid)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA .".professional set paymentid = :paymentid where id = :id;";
		$this->_bind = array(':paymentid' => $subscriptionid, ':id' => $id );
		$result = $this->custom($query);
		return $result;
	}

	public function userauthenticationfromid($id)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA .".professional set authuser = TRUE where id = :id;";
		$this->_bind = array(':id' => $id );
		$result = $this->custom($query);
		return $result;
	}

	public function userdeauthenticationfromid($id)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA .".professional set paymentid = NULL, authuser = FALSE where id = :id;";
		$this->_bind = array(':id' => $id );
		$result = $this->custom($query);
		return $result;
	}

	public function userauthentication($subscriptionid)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA .".professional set authuser = TRUE where paymentid = :paymentid;";
		$this->_bind = array(':paymentid' => $subscriptionid );
		$result = $this->custom($query);
		return $result;
	}

	public function userdeauthentication($subscriptionid)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA .".professional set paymentid = NULL, authuser = FALSE where paymentid = :paymentid;";
		$this->_bind = array(':paymentid' => $subscriptionid );
		$result = $this->custom($query);
		return $result;
	}

	public function getpaymentid($id)
	{
		$this->_fetch = fetch;
		$query = 'SELECT paymentid FROM '.DB_SCHEMA.'.professional WHERE id = :id';
		$this->_bind = array(':id' => $id);
		$result = $this->custom($query);
		return $result[0];
	}

	public function getemailfromsub($subscriptionid)
	{
	    $query = 'SELECT email FROM '.DB_SCHEMA.'.professional WHERE paymentid = :paymentid';
		$this->_bind = array(':paymentid' => $subscriptionid);
		$result = $this->custom($query);
		return $result[0];
	}
}
