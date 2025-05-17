BEGIN

SELECT  DISTINCT ON (message.threadid) message.messageid as msgid, message.threadid as threadidfromselect, messagethread.closedby as closedby  from website.message left join website.messagethread on message.threadid = messagethread.threadid where (message.recipientid = recipient and message.senderid = sender) OR (message.recipientid=sender and message.senderid=recipient) order by message.threadid, message.messageid DESC;

IF (closedby IS NULL) THEN
     INSERT INTO website.message (message.createdat, message.message, message.parentmessageid, message.threadid, message.senderid, message.recipientid, message.recipientread) VALUES (NOW(), message, msgid, threadidfromselect,sender,recipient,false);

ELSE
   WITH insertthread AS ( INSERT INTO website.messagethread (messagethread.createdat) VALUES (NOW()) RETURNING messagethread.threadid as threadidfrominsert),
INSERT INTO website.message (message.createdat, message.message, message.parentmessageid, message.threadid, message.senderid, message.recipientid, message.recipientread) VALUES (NOW(), message, NULL, SELECT threadidfrominsert FROM insertthread,sender,recipient,false);

END IF;
END;

/* INSERT MESSAGE into database, if message between users exists and if the thread is not closed then new message is inserted only in messages table with previous thread as threadid and previous message as parent message. If conversation between two doesn't exist or thread is closed a new thread is opened and new message ref to that thread with no parent is created. */

CREATE FUNCTION "website"."createmessage" (IN messagetext text,IN sender bigint,IN recipient bigint) RETURNS void AS $$
DECLARE
msg message;
BEGIN

SELECT DISTINCT ON (message.threadid) message.messageid as msgid, message.threadid as threadidfromselect, messagethread.closedby as closedby  from website.message left join website.messagethread on message.threadid = messagethread.threadid where (message.recipientid = recipient and message.senderid = sender) OR (message.recipientid=sender and message.senderid=recipient) order by message.threadid, message.messageid DESC INTO msg;

IF msg.closedby IS NULL THEN
     INSERT INTO website.message (message.createdat, message.messagetext, message.parentmessageid, message.threadid, message.senderid, message.recipientid, message.recipientread) VALUES (now(), messagetext, msg.msgid, msg.threadidfromselect,sender,recipient,false);

ELSE
   WITH insertthread AS ( INSERT INTO website.messagethread (messagethread.createdat) VALUES (NOW()) RETURNING messagethread.threadid as threadidfrominsert)
INSERT INTO website.message (message.createdat, message.messagetext, message.parentmessageid, message.threadid, message.senderid, message.recipientid, message.recipientread) VALUES (NOW(), messagetext, NULL, (SELECT threadidfrominsert FROM insertthread),sender,recipient,false);

END IF;
END;




    $$ LANGUAGE "plpgsql"


DECLARE
msg record;
BEGIN

SELECT DISTINCT ON (message.threadid) message.messageid as msgid, message.threadid as threadidfromselect, messagethread.closedby as closedby  from website.message left join website.messagethread on message.threadid = messagethread.threadid where (message.recipientid = recipient and message.senderid = sender) OR (message.recipientid=sender and message.senderid=recipient) order by message.threadid, message.messageid DESC into msg ;

IF msg.closedby IS NULL THEN
     INSERT INTO website.message (createdat, messagetext, parentmessageid, threadid, senderid, recipientid, recipientread) VALUES (now(), messagetext, msg.msgid, msg.threadidfromselect,sender,recipient,false);

ELSE
   WITH insertthread AS ( INSERT INTO website.messagethread (createdat) VALUES (NOW()) RETURNING messagethread.threadid as threadidfrominsert)
INSERT INTO website.message (createdat, messagetext, parentmessageid, threadid, senderid, recipientid, recipientread) VALUES (NOW(), messagetext, NULL, (SELECT threadidfrominsert FROM insertthread),sender,recipient,false);

END IF;



END;

DECLARE
msg record;
BEGIN

SELECT DISTINCT ON (message.threadid) message.messageid as msgid, message.threadid as threadidfromselect, messagethread.closedby as closedby  from website.message left join website.messagethread on message.threadid = messagethread.threadid where ((message.recipientid = recipient and message.senderid = sender) OR (message.recipientid=sender and message.senderid=recipient)) order by message.threadid DESC, message.messageid DESC LIMIT 1 into msg;

IF FOUND AND (msg.closedby IS NULL) THEN
     INSERT INTO website.message (createdat, messagetext, parentmessageid, threadid, senderid, recipientid, recipientread) VALUES (now(), messagetext, msg.msgid, msg.threadidfromselect,sender,recipient,false);

ELSE
   WITH insertthread AS ( INSERT INTO website.messagethread (createdat) VALUES (NOW()) RETURNING threadid as threadidfrominsert)
INSERT INTO website.message (createdat, messagetext, parentmessageid, threadid, senderid, recipientid, recipientread) VALUES (NOW(), messagetext, NULL, (SELECT threadidfrominsert FROM insertthread),sender,recipient,false);

END IF;


END;
