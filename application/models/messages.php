<?php

class Messages extends Model
{
	function __construct()
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$this->_table = 'message';
		parent::__construct();

	}

	public function closemessagebyuser($threadid)
	{
		$this->_fetch = fetch;
		$query = "UPDATE ".DB_SCHEMA.".messagethread t SET closedby = :userid, closedon = NOW() FROM ".DB_SCHEMA.".message m WHERE t.threadid = :threadid AND (m.recipientid = :userid OR m.senderid= :userid) AND closedby IS NULL returning t.paidby;";
		$this->_bind[':userid'] = $_SESSION['id'];
		$this->_bind[':threadid'] = $threadid;
		$result = $this->custom($query);
		return $result;
	}

	public function sendinitialprofmessage($orderid, $threadid,$senderid, $recipientid, $parentid, $messagetext, $email,$username)
	{
		$this->_fetch = fetch;
		$query = "WITH messagecond as (SELECT messageid , threadid, senderid, recipientid from ".DB_SCHEMA.".message where threadid = :threadid ORDER BY messageid limit 1),
			addorder as (UPDATE ".DB_SCHEMA.".messagethread mt SET (orderid) = (:orderid) FROM messagecond WHERE mt.threadid = messagecond.threadid and messagecond.senderid = :recipientid and messagecond.recipientid = :senderid and orderid is NULL returning orderid, mt.threadid)
			INSERT INTO ".DB_SCHEMA.".message  (messagetext, parentmessageid, senderid, recipientid, createdat, recipientread,threadid) SELECT :messagetext, :parentid, :senderid,:recipientid,NOW(), FALSE, :threadid FROM messagecond left join addorder on addorder.threadid = messagecond.threadid where  messagecond.senderid = :recipientid and messagecond.recipientid = :senderid and messagecond.threadid =:threadid and  addorder.orderid = :orderid returning messageid";
			 //NOTE : *I HAVE JUST ADDED CONDITION AS (messagecond.recipientid = :senderid and messagecond.senderid = :recipientid) ASSUMING that the first message is always sent by the user...... but it may be possible(?) that prof sent the first message (?) {ALTHOUGH, THE WHOLE THING IS BASED ON FIRST MESSAGE THING, AS WHO INITIATES, AS WHO DOESN'T GET THIS PAYMENT OPTIONS (see MessagesController if(firstmessage not sent by user)} then the condition will be (messagecond.recipientid = :senderid or messagecond: :senderid) and (messagecond.recipientid = :recipientid or messagecond.senderid = :recipientid)
		$this->_bind[':orderid'] = $orderid;
		$this->_bind[':messagetext'] = htmlspecialchars($messagetext);
    $this->_bind[':senderid'] = $senderid;
 		$this->_bind[':recipientid'] = $recipientid;
 		$this->_bind[':threadid'] = $threadid;
 		$this->_bind[':parentid'] = $parentid;
    $result = $this->custom($query);
		if($result['messageid'] && filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			//sendemail
			$send = new sendEmail();
			$stripmsg = strip_tags($messagetext);
			$emailmsg = strlen($stripmsg) > 50 ? substr($stripmsg,0,50)."..." : $stripmsg;
			$send->email($email, 'New message from ' . $_SESSION['username'], "<p>Hello ".$username.",</p><p></p><p>You have recieved a new message from ".$_SESSION['username'].":</p><p></p><p style='background: lightgrey; padding:2%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>" .$emailmsg."</p><p></p><p><a href='".BASE_PATH."/messages'>View Message</a></p>", UPDATES_EMAIL);


		}
		return $result['messageid'];
	}
	public function sendmessage($senderid, $recipientid, $threadid, $parentid, $messagetext, $attachment, $attachmentname, $attachmentext, $email,$username)
	{
		$this->_fetch = fetch;
		$query ='';

		if($attachment)
		{


			$query = "SELECT messageid, attachmentid from ".DB_SCHEMA.".replymessage(:threadid::bigint, :senderid::bigint,:recipientid::bigint,:messagetext::varchar, :parentmessageid::bigint, :attachmentname::varchar, :attachmentextension::varchar) AS ( messageid BIGINT, attachmentid BIGINT);";
			$this->_bind[':attachmentname'] = $attachmentname;
			$this->_bind[':attachmentextension'] = $attachmentext;
		}
		else $query = "SELECT messageid from ".DB_SCHEMA.".replymessage(:threadid::bigint,:senderid::bigint,:recipientid::bigint,:messagetext::varchar, :parentmessageid::bigint) AS ( messageid BIGINT);";

		$this->_bind[':messagetext'] = $messagetext;
    $this->_bind[':senderid'] = $senderid;
		$this->_bind[':recipientid'] = $recipientid;
		$this->_bind[':threadid'] = $threadid;
		$this->_bind[':parentmessageid'] = $parentid;
    $result = $this->custom($query);

		if(intval($result['messageid']) && filter_var($email, FILTER_VALIDATE_EMAIL))
		{

			//send email to user
			$send = new sendEmail();
			$stripmsg = strip_tags(htmlspecialchars_decode($messagetext));
			$emailmsg = strlen($stripmsg) > 50 ? substr($stripmsg,0,50)."..." : $stripmsg;
			$send->email($email, 'New message from ' . $_SESSION['username'], "<p>Hello ".$username.",</p><p></p><p>You have recieved a new message from ".$_SESSION['username'].":</p><p></p><p style='background: lightgrey; padding:2%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>" .$emailmsg."</p><p></p><p><a href='".BASE_PATH."/messages'>View Message</a></p>", UPDATES_EMAIL);

		}

		if(intval($result['attachmentid']))
		{
			if($attachment)
			{
				//CHANGEDNOV19: CHANGE WINDOWS DRIVE TO LINUX DRIVE-->> DS.'home'.DS.'kniewcom'.DS.'upload'.DS.'attachment'.DS.'
				// if 0-1000 -> dir 0...
				$attachmentfile = 'E:'. DS. 'upload' . DS . 'attachment' .DS.$result['attachmentid'] . '.' . $attachmentext;
				move_uploaded_file($attachment, $attachmentfile);

			}
		}
		return $result;
	}

  public function sendmessagefromprofpage($messagetext, $subject, $senderid, $recipientid, $email, $username)
  {
    $this->_fetch = 0;
		$query = 'SELECT 1 FROM ' . DB_SCHEMA . '.createmessage(:messagetext::text,:senderid::bigint ,:recipientid::bigint, :subject::varchar)';
    $this->_bind = array(':messagetext' => $messagetext,
                    ':senderid' => $senderid,
										':recipientid' => $recipientid,
					        	':subject' => $subject,
					        	);
    $result = $this->custom($query);
		if($result && filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			//check if first message possible?
			$send = new sendEmail();
			$stripmsg = htmlspecialchars_decode($messagetext);
			$emailmsg = strlen($stripmsg) > 50 ? substr($stripmsg,0,50)."..." : $stripmsg;
			$send->email($email, 'New message from ' . $_SESSION['username'] . ' : '. htmlspecialchars_decode($subject), "<p>Hello ".$username.",</p><p></p><p>You have recieved a new message from ".$_SESSION['username'].":</p><p></p><p style='background: lightgrey; padding:2%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>" .$emailmsg."</p><p></p><p><a href='".BASE_PATH."/messages'>View Message</a></p>", UPDATES_EMAIL);
		}
    return $result;
  }

	public function getattachment($messageid, $attachmentname)
	{
		$this->_fetch = fetch;
		$query = "SELECT attachmentid, attachmentextension FROM ".DB_SCHEMA.".messageattachment JOIN ".DB_SCHEMA.".message ON attachmentmessageid = messageid WHERE attachmentname = :attachmentname AND attachmentmessageid = :messageid AND (senderid = :user OR recipientid = :user)"; //no need to output attachmentid and risk injection, as each message has only one attachment anyway i will put other conditon and output attachmentid, this way user will be autheticated
		$this->_bind = array(':messageid' => $messageid,
													':attachmentname' => $attachmentname,
													':user' => $_SESSION['id']
												);
		$result = $this->custom($query);
		return $result;
	}
	public function getallmessages($loggedinid,$page, $perpage = 10, $isrefresh = false, $refreshtimeinsec = 60)
  {
    $start = ($page-1)*$perpage;
    if ($start<0) $start = 0;
		$orderby = ' DESC ';
		$limit = "OFFSET ".$start." LIMIT ".$perpage;

		$refreshcondition = '';
		$selectno = '';
		$closerefresh = '';
		if($isrefresh == true)
		{
			$selectno = '(SELECT count(*) as noofunreadmessages FROM (SELECT DISTINCT ON(threadid) threadid FROM website.message WHERE recipientid = :loggedinid AND recipientread = FALSE ORDER BY threadid DESC,messageid DESC) AS unreadthreads
				) noofunread
				left join
				(';
			$refreshcondition = " AND m.createdat > (current_timestamp - interval '".$refreshtimeinsec." seconds') " ;
			$closerefresh = " msgs ON 1=1) ";
			$orderby = ' ASC ';
			$limit = '';
		}

    $query = "SELECT *,paidby, closedon, subject  FROM (
			".$selectno."
			SELECT DISTINCT ON (m.threadid) *
              FROM (
                 SELECT 'out' AS type, recipientid AS userid,threadid, messageid, messagetext, createdat, recipientread
                 FROM " . DB_SCHEMA . ".message
                 WHERE  senderid = :loggedinid
                 UNION  ALL
                 SELECT 'in' AS type, senderid AS userid, threadid, messageid, messagetext, createdat, recipientread
                 FROM   " . DB_SCHEMA . ".message
                 WHERE  recipientid = :loggedinid
               ) m join messagethread t on t.threadid = m.threadid ".$refreshcondition." inner JOIN(
              SELECT id, username as username, email as email, profilepic as profilepic,usertype as usertype FROM " . DB_SCHEMA . ".professional UNION select id, username as username, email as email, USERDETAILS->>'profilepic' AS profilepic, usertype as usertype FROM " . DB_SCHEMA . ".usernormal) AS u ON (u.id = m.userid) ORDER BY m.threadid desc, messageid DESC)
							".$closerefresh." fororder
                ORDER  BY closedon DESC NULLS FIRST,messageid desc,paidby NULLS LAST  ".$limit.";";
    $this->_bind = array(':loggedinid' => $loggedinid);
    $result = $this->custom($query);
    return $result;

  }

	// if want to incluse closedon and sortby that but seems too complicated -- but i guess i should so that know before opening which is closed and paid? or not.. because opening will reveal if its closed.. may be in future?
	// SELECT paidby,closedon, * FROM (SELECT DISTINCT ON (m.threadid) *
  //             FROM (
  //                SELECT 'out' AS type, recipientid AS userid,threadid, messageid, messagetext, createdat, recipientread
  //                FROM message
  //                WHERE  senderid = 7
  //                UNION  ALL
  //                SELECT 'in' AS type, senderid AS userid, threadid, messageid, messagetext, createdat, recipientread
  //                FROM   message
  //                WHERE  recipientid = 7
  //              ) m join messagethread t on t.threadid = m.threadid inner JOIN(
  //             SELECT id, username as username, profilepic as profilepic,usertype as usertype FROM professional UNION select id, username as username, USERDETAILS->>'profilepic' AS profilepic, usertype as usertype FROM usernormal) AS u ON (u.id = m.userid) ORDER BY m.threadid DESC, messageid DESC) fororder
  //             ORDER  BY closedon DESC NULLS FIRST,messageid desc,paidby NULLS LAST

	public function getthreadmessages($threadid, $userid, $getparent = array(), $page, $perpage = 10, $afterparent = 0,$isunread=false,$refreshid = null)
	{
		$start = ($page-1)*$perpage + $afterparent;
		// if($page == 2 && $afterparent != 0) $start = $perpage + $afterparent;
    if ($start<0) $start = 0;

		$query ='';
		$update ='';
		$selectno = '';
		$wherecondition = '';
		$limit = '';
		$usercondition = '';

		if($refreshid != NULL)
		{
			$update = "UPDATE " . DB_SCHEMA .".message SET recipientread = TRUE where threadid = :uthreadid and recipientid = :recipientid; ";
			$this->_bind[':recipientid'] = $_SESSION['id'];
			$this->_bind[':uthreadid'] = $threadid;

			$query = $update. "SELECT * FROM
				(SELECT count(*) as noofunreadmessages FROM (SELECT DISTINCT ON(threadid) threadid FROM ".DB_SCHEMA.".message WHERE recipientid = :loggeduser AND recipientread = FALSE ORDER BY threadid DESC,messageid DESC) AS unreadthreads) numberquery
				LEFT JOIN
				(SELECT t.paidby, t.closedby, t.closedon, t.orderid from website.messagethread t where t.threadid = :threadid) threadquery
				ON 1=1
				LEFT JOIN
				(SELECT m.messageid, m.createdat, m.messagetext, m.parentmessageid, m.senderid, m.recipientid, m.recipientread, p.messagetext as parentmessagetext, a.attachmentname  from " . DB_SCHEMA . ".message m LEFT JOIN " . DB_SCHEMA . ".message p ON m.parentmessageid = p.messageid LEFT JOIN ".DB_SCHEMA.".messageattachment a ON m.messageid = a.attachmentmessageid WHERE m.threadid = :threadid  AND m.senderid = :otheruser and m.recipientid = :loggeduser and m.messageid > :refreshid ORDER BY m.messageid ASC) 	messagequery
				ON 1=1;";
			$this->_bind[':refreshid'] = $refreshid;

		}
		else
		{
			if(($page == 1 && $isunread))
			{
				$update = "UPDATE " . DB_SCHEMA .".message SET recipientread = TRUE where threadid = :uthreadid and recipientid = :recipientid; ";
				$this->_bind[':recipientid'] = $_SESSION['id'];
				$this->_bind[':uthreadid'] = $threadid;
			}
			if(isset($getparent) && $getparent['getparent'] == true)
			{
				$wherecondition = " and (m.messageid < :lastmessageid and m. messageid >= :parenttoget) ";
				$this->_bind[':lastmessageid'] = $getparent['lastmessageid'];
				$this->_bind[':parenttoget'] = $getparent['parenttoget'];
			}
			else $limit = " OFFSET ".$start." LIMIT ".$perpage;

			$query = $update . "SELECT m.messageid, m.createdat, m.messagetext, m.parentmessageid, m.senderid, m.recipientid, m.recipientread, p.messagetext as parentmessagetext, a.attachmentname, t.paidby, t.closedby, t.closedon, t.orderid  from " . DB_SCHEMA . ".message m LEFT JOIN " . DB_SCHEMA . ".message p ON m.parentmessageid = p.messageid LEFT JOIN ".DB_SCHEMA.".messageattachment a ON m.messageid = a.attachmentmessageid INNER JOIN ". DB_SCHEMA .".messagethread t ON t.threadid = m.threadid WHERE m.threadid = :threadid ".$wherecondition." AND ((m.senderid = :loggeduser AND m.recipientid = :otheruser) OR (m.senderid = :otheruser AND m.recipientid = :loggeduser))  ORDER BY m.messageid DESC ".$limit." ;";
			$usercondition = '';
		}
		// $query = $update . "SELECT m.messageid, m.createdat, m.messagetext, m.parentmessageid, m.senderid, m.recipientid, m.recipientread, p.messagetext as parentmessagetext, a.attachmentname, t.paidby, t.closedby, t.closedon, t.orderid  from " . DB_SCHEMA . ".message m LEFT JOIN " . DB_SCHEMA . ".message p ON m.parentmessageid = p.messageid LEFT JOIN ".DB_SCHEMA.".messageattachment a ON m.messageid = a.attachmentmessageid INNER JOIN ". DB_SCHEMA .".messagethread t ON t.threadid = m.threadid WHERE m.threadid = :threadid ".$wherecondition. $usercondition. " ORDER BY m.messageid DESC ".$limit." ;";
		$this->_bind[':threadid'] = $threadid;
		$this->_bind[':loggeduser'] = $_SESSION['id'];
		$this->_bind[':otheruser'] = $userid;
    $result = $this->custom($query,true);
    return $result;
		//
		//offset start + countofparent.. don't increase page number for parent
	}

	public function noofunreadmessages()
	{
		$this->_fetch = fetch;
		$query = "SELECT count(*) as noofunreadmessages FROM (SELECT DISTINCT ON(threadid) threadid FROM ".DB_SCHEMA.".message WHERE recipientid = :id AND recipientread = FALSE ORDER BY threadid DESC,messageid DESC) AS unreadthreads";
		$this->_bind[':id'] = $_SESSION['id'];
		$result = $this->custom($query);
		return $result;
	}

}


/*
SELECT m.*, CASE WHEN u2.id = 7
              THEN u1.username
              ELSE u2.username
            END as participant
FROM message m
JOIN userall u1 ON m.senderid=u1.id
JOIN userall u2 ON m.recipientid=u2.id
WHERE m.messageid IN (
SELECT MAX(messageid)
FROM message
WHERE senderid = 7 OR recipientid =7
GROUP BY threadid) ORDER BY m.messageid DESC
;
*/

/*
select senderid, messagetext, parentid
on click of thread, take threadid, userids, username, pic,type sort desc, limit to 5(?)
pagination - in reverse..
if $_SESSION[id] = sender id -> align right else align Left
if parentid != the one above (make ref (in reply to))

*/
