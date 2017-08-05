CREATE TABLE category_information (
    id integer NOT NULL auto_increment,
    category varchar(255) NOT NULL,
    objectattribute_id integer NOT NULL default '0',
    PRIMARY KEY (id)
);
