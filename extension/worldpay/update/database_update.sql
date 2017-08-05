--
-- Table structure for table 'worldpay'
--

DROP TABLE IF EXISTS worldpay;
CREATE TABLE worldpay (
  id int(11) NOT NULL auto_increment,
  order_id int(11) NOT NULL default '0',
  user_id int(11) NOT NULL default '0',
  price double default NULL,
  postcode varchar(10) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  payed int(1) NOT NULL default '0',
  created int(11) NOT NULL default '0',
  session varchar(32) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
