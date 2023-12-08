CREATE TABLE `ezpm_contact` (
  `user_id` int(11) NOT NULL default '0',
  `contact_user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`contact_user_id`)
);


CREATE TABLE `ezpm` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL default '',
  `text` tinyblob NOT NULL,
  `date_read` int(11) NOT NULL default '0',
  `date_sent` int(11) NOT NULL default '0',
  `sender_id` int(11) NOT NULL default '0',
  `sender_name` varchar(255) NOT NULL default '',
  `recipient_id` int(11) NOT NULL default '0',
  `recipient_name` varchar(255) NOT NULL default '',
  `owner_user_id` int(11) NOT NULL default '0',
  `remote_id` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
);


CREATE TABLE `ezpm_blacklist` (
  `user_id` int(11) NOT NULL default '0',
  `blocked_user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`blocked_user_id`)
);

