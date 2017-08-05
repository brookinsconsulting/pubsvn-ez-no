CREATE TABLE ezsurvey (
    id int(11) NOT NULL auto_increment,
    title varchar(255) DEFAULT '' NOT NULL,
    enabled int(11) DEFAULT '1' NOT NULL,
    published int(11) DEFAULT '0' NOT NULL,
    PRIMARY KEY (id)
) TYPE=MyISAM;

CREATE TABLE ezsurveyquestion (
    id int(11) NOT NULL auto_increment,
    survey_id int(11) DEFAULT '0' NOT NULL,
    tab_order int(11) DEFAULT '0' NOT NULL,
    type varchar(255) DEFAULT '' NOT NULL,
    text longtext,
    text2 longtext,
    num int(11),
    num2 int(11),
    PRIMARY KEY (id),
    KEY ezsurveyquestion_survey_id (survey_id)
) TYPE=MyISAM;

CREATE TABLE ezsurveyresult (
    id int(11) NOT NULL auto_increment,
    survey_id int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    PRIMARY KEY (id),
    KEY ezsurveyresult_survey_id (survey_id)
) TYPE=MyISAM;

CREATE TABLE ezsurveyquestionresult (
    id int(11) NOT NULL auto_increment,
    result_id int(11) DEFAULT '0' NOT NULL,
    question_id int(11) DEFAULT '0' NOT NULL,
    text varchar(255),
    PRIMARY KEY (id),
    KEY ezsurveyquestionresult_result_id (result_id),
    KEY ezsurveyquestionresult_question_id (question_id)
) TYPE=MyISAM;

CREATE TABLE ezsurveymetadata (
    id int(11) NOT NULL auto_increment,
    result_id int(11) DEFAULT '0' NOT NULL,
    attr_name varchar(255) NOT NULL,
    attr_value varchar(255) NOT NULL,
    PRIMARY KEY (id),
    KEY ezsurveymetadata_result_id (result_id),
    KEY ezsurveymetadata_attr_name (attr_name),
    KEY ezsurveymetadata_attr_value (attr_value)
) TYPE=MyISAM;
