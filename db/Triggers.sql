--  1 trigger
DELIMITER $$
CREATE TRIGGER `delete_contact`
AFTER UPDATE ON contacts
FOR EACH ROW
BEGIN
   UPDATE messages 	
   SET `deleted` = NOW() 
   WHERE IFNULL(deleted, ((sender_id = NEW.`user_id` AND receiver_id = NEW.`contact_id`) OR (receiver_id = NEW.`user_id` AND sender_id = NEW.`contact_id`)))
   ;
END
$$

--  second trigger
CREATE DEFINER=`root`@`localhost` TRIGGER `on_contact_delete`
AFTER UPDATE ON contacts
FOR EACH ROW
BEGIN
if NEW.deleted IS NOT NULL then
   UPDATE messages 	
   SET `deleted_receiver` = NOW() 
   WHERE IFNULL(deleted_receiver, receiver_id = NEW.`user_id` AND sender_id = NEW.`contact_id`)
   ;
   UPDATE messages 	
   SET `deleted_sender` = NOW() 
   WHERE IFNULL(deleted_sender, receiver_id = NEW.`contact_id` AND sender_id = NEW.`user_id`)
   ;
   end if;
END

-- 3 trigger
CREATE DEFINER=`root`@`localhost` FUNCTION `delete_contact`(user_id INT, contact_id INT) RETURNS int(11)
BEGIN
UPDATE contacts
SET deleted = current_timestamp
WHERE user_id = user_id AND contact_id = contact_id
;
RETURN 1;
END