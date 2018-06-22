
create table USERS ( 
	USER_ID DOUBLE not null AUTO_INCREMENT, 
		CONSTRAINT USERS_PK 
        PRIMARY KEY(USER_ID) , 
	NAME VARCHAR(20) not null, 
	SURNAME VARCHAR(20) not null, 
	EMAIL VARCHAR(30) not null, 
	PASSWORD VARCHAR(100) not null, 
	PHONE_NUMBER VARCHAR(11) default NULL, 
	ADDRESS VARCHAR(200) default NULL, 
	USER_NAME VARCHAR(20) not null, 
	AGE DOUBLE 
);

create unique index USERS_USER_NAME_UINDEX
	on USERS (USER_NAME);


create table ADMINS
(
	USER_ID DOUBLE not null primary KEY AUTO_INCREMENT,
		CONSTRAINT ADMINS_USERS__FK 
        FOREIGN KEY (USER_ID)
		REFERENCES users(`USER_ID`) 
        on delete cascade,
	CATEGORY_PERMISSION TINYINT not null
);

create table LEADADMINS ( 
	USER_ID DOUBLE not null primary key AUTO_INCREMENT, 
		constraint LEADADMINS_ADMINS_FK 
        FOREIGN KEY (USER_ID) 
        REFERENCES ADMINS(`USER_ID`) 
			on delete cascade, 
	CATEGORY_COUNT DOUBLE not null default 0 
);

create table SUBADMINS ( 
	USER_ID DOUBLE not null primary key AUTO_INCREMENT, 
		constraint SubAdmins_ADMINS_FK 
        FOREIGN KEY (USER_ID) 
        REFERENCES ADMINS(`USER_ID`) 
			on delete cascade
);

create table MEMBERS
(
	USER_ID DOUBLE not null	primary key AUTO_INCREMENT,
		CONSTRAINT MEMBERS_USERS_FK
			FOREIGN KEY (USER_ID)
			REFERENCES USERS(`USER_ID`) 
            on delete cascade,
	ANNOUNCEMENT_PERMISSION DOUBLE not null,
	MEMBER_STATUS VARCHAR(20)  not null
);


create table CATEGORIES ( 
	CATEGORY_ID DOUBLE not null primary key AUTO_INCREMENT, 
	PARENT_CAT_ID DOUBLE, 
    constraint CATEGORIES_CATEGORY_ID_FK FOREIGN KEY (PARENT_CAT_ID) references CATEGORIES(CATEGORY_ID) on delete cascade, 
	NAME VARCHAR(30) not null 
);

create unique index CATEGORIES_NAME_UINDEX
	on CATEGORIES (NAME);


create table PRODUCTS
(
	PRODUCT_ID DOUBLE not null primary key AUTO_INCREMENT,
    CATEGORY_ID DOUBLE,
		constraint PRODUCTS_CATEGORY_ID_FK 
		FOREIGN KEY (CATEGORY_ID) 
        references CATEGORIES(CATEGORY_ID ) 
			on delete cascade,
    USER_ID DOUBLE,
		constraint PRODUCTS_USERS_USER_ID_FK 
		FOREIGN KEY (USER_ID) 
        references MEMBERS(USER_ID) 
			on delete cascade,
    NAME VARCHAR(50) not null,
	COLOR VARCHAR(20),
	MARK VARCHAR(20),
	DIMENSION VARCHAR(20)
);


create table WISHLISTS
(
	WISHLIST_ID DOUBLE not null 
		primary key auto_increment,
	PRODUCT_ID DOUBLE,
		constraint WISHLISTED_ID_FK 
        FOREIGN KEY (PRODUCT_ID) 
			references PRODUCTS(PRODUCT_ID) 
				on delete cascade,
	USER_ID DOUBLE,
		constraint WISHLIST_MEMBERS_USER_ID_FK
        FOREIGN KEY (USER_ID)
			references MEMBERS(USER_ID)
				on delete cascade
);


create table CITIES
(
	CITY_ID DOUBLE not null
		primary key auto_increment,
	NAME VARCHAR(20) not null
);


create unique index CITIES_NAME_UINDEX
	on CITIES (NAME);

create table DISTRICTS
(
	DISTRICT_ID DOUBLE not null
		primary key auto_increment,
	CITY_ID DOUBLE,
		constraint DISTRICTS_CITIES_CITY_ID_FK
        FOREIGN KEY (CITY_ID)
			references CITIES(CITY_ID)
				on delete cascade,
	NAME VARCHAR(20) not null
);

create table ANNOUNCEMENTS
(
	ANNOUNCEMENT_ID DOUBLE not null
		primary key auto_increment,
	PRODUCT_ID DOUBLE not null,
		constraint ANNOUNCEMENTS_PRODUCT_ID_FK
        FOREIGN KEY (PRODUCT_ID)
			references PRODUCTS(PRODUCT_ID)
				on delete cascade,
	USER_ID DOUBLE not null,
		constraint ANNOUNCEMENTS_USER_ID_FK
        FOREIGN KEY (USER_ID)
			references MEMBERS(USER_ID)
				on delete cascade,
	CITY_ID DOUBLE not null,
		constraint ANNOUNCEMENTS_CITY_ID_FK
        FOREIGN KEY (CITY_ID)
			references CITIES(CITY_ID)
				on delete cascade,
	DISTRICT_ID DOUBLE not null,
		constraint ANNOUNCEMENTS_DISTRICT_ID_FK
        FOREIGN KEY(DISTRICT_ID)
			references DISTRICTS(DISTRICT_ID)
				on delete cascade,
	TITLE VARCHAR(100) not null,
	PRICE DOUBLE not null,
	DETAILS VARCHAR(1000) default NULL,
	START_DATE DATETIME not null,
	END_DATE DATETIME not null,
	ANNOUNCEMENT_STATUS VARCHAR(20) not null
	
);

drop table if exists COMPLAINTS;
create table COMPLAINTS
(
	COMPLAINT_ID DOUBLE not null
		primary key auto_increment,
	USER_ID DOUBLE not null,
		constraint COMPLAINTS_MEMBERS_USER_ID_FK
        FOREIGN KEY (USER_ID)
			references MEMBERS(USER_ID)
				on delete cascade,
	DETAILS VARCHAR(500),
	SUBJECT VARCHAR(50) not null
);

create table SALE_RECORDS
(
	RECORD_ID DOUBLE not null
		primary key auto_increment,
	ANNOUNCEMENT_ID DOUBLE,
		constraint RECORDS_ANNOUNCEMENT_ID_FK
        FOREIGN KEY (ANNOUNCEMENT_ID)
			references ANNOUNCEMENTS(ANNOUNCEMENT_ID)
				on delete cascade,
	PRODUCT_ID DOUBLE,
		constraint RECORDS_PRODUCT_ID_FK
        FOREIGN KEY (PRODUCT_ID)
			references PRODUCTS(PRODUCT_ID)
				on delete cascade,
	SELLER_ID DOUBLE,
		constraint SALE_RECORDS_SELLER_FK
        FOREIGN KEY (SELLER_ID)
			references MEMBERS(USER_ID)
				on delete cascade,
	BUYER_ID DOUBLE,
		constraint SALE_RECORDS_BUYER_FK
        FOREIGN KEY (BUYER_ID)
			references MEMBERS(USER_ID)
				on delete cascade
);

create table CARGO_COMPANIES
(
	COMPANY_ID DOUBLE not null
		primary key auto_increment,
	NAME VARCHAR(20) not null,
	ADDRESS VARCHAR(100) not null,
	PHONE_NUMBER VARCHAR(10) not null
);


create unique index CARGO_COMPANIES_NAME_UINDEX
	on CARGO_COMPANIES (NAME);


create table CARGO_RECORDS
(
	CARGO_RECORD_ID DOUBLE not null
		primary key auto_increment,
	COMPANY_ID DOUBLE,
		constraint CARGO_RECORDS_COMPANY_ID_FK
        FOREIGN KEY (COMPANY_ID)
			references CARGO_COMPANIES(COMPANY_ID)
				on delete cascade,
	SALE_RECORD_ID DOUBLE,
		constraint CARGO_RECORDS_RECORD_ID_FK
        FOREIGN KEY (SALE_RECORD_ID)
			references SALE_RECORDS(RECORD_ID)
				on delete cascade,
	`DATE` DATETIME not null
);

create table PROCESSING_HISTORIES
(
	PROCESSING_HISTORY_ID DOUBLE not null
		primary key auto_increment,
	USER_ID DOUBLE,
		constraint PROCESSING_HISTORY_USER_ID_FK
        FOREIGN KEY (USER_ID)
			references USERS(USER_ID)
				on delete cascade,
	ACTIVITY VARCHAR(200) not null,
	`DATE` DATETIME not null
);

create table WARRANTIES
(
	WARRANTY_ID DOUBLE not null
		primary key auto_increment,
	PRODUCT_ID DOUBLE not null,
		constraint WARRANTY_PRODUCT_ID_FK
        FOREIGN KEY (PRODUCT_ID)
			references PRODUCTS(PRODUCT_ID)
				on delete cascade,
	END_DATE DATETIME not null,
	START_DATE DATETIME not null
);

create table IMAGES
(
	IMAGE_ID DOUBLE not null
		primary key auto_increment,
	PRODUCT_ID DOUBLE not null,
		constraint IMAGES_PRODUCTS_PRODUCT_ID_FK
        FOREIGN KEY (PRODUCT_ID)
			references PRODUCTS(PRODUCT_ID)
				on delete cascade,
	URL VARCHAR(200) not null
);


create unique index IMAGES_URL_UINDEX
	on IMAGES (URL);

create table MESSAGES
(
	MESSAGE_ID DOUBLE not null
		primary key auto_increment,
	TO_USER DOUBLE,
		constraint TO_USER_ID_FK
        FOREIGN KEY(TO_USER)
			references USERS(USER_ID)
				on delete cascade,
	FROM_USER DOUBLE,
		constraint FROM_USER_ID_FK
        FOREIGN KEY (FROM_USER)
			references USERS(USER_ID)
				on delete cascade,
	SUBJECT VARCHAR(50) not null,
	TEXT VARCHAR(500) not null
);





drop procedure if exists insertSUBADMIN;

DELIMITER $$

create PROCEDURE insertSUBADMIN(
  IN p_name VARCHAR(4000) ,
  IN p_surname VARCHAR(4000) ,
  IN p_email VARCHAR(4000) ,
  IN p_password VARCHAR(4000) ,
  IN p_phone_number VARCHAR(4000) ,
  IN p_address VARCHAR(4000) ,
  IN p_user_name VARCHAR(4000) ,
  IN p_age VARCHAR(4000) )
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;
  /*/*RAISE;*/
  END;

	INSERT INTO USERS (`USER_ID`, `NAME`, `SURNAME`, `EMAIL`, `PASSWORD`, `PHONE_NUMBER`, `ADDRESS`, `USER_NAME`, `AGE`)
  VALUES (NULL, p_name, p_surname, p_email, p_password, p_phone_number, p_address, p_user_name, p_age);

	INSERT INTO ADMINS (`USER_ID`, `CATEGORY_PERMISSION`)
  VALUES (last_insert_id(), 0);

  INSERT INTO SUBADMINS (`USER_ID`)
  VALUES (last_insert_id());

  COMMIT;


END$$


DELIMITER ;



drop procedure if exists insertLEADADMIN;

delimiter $$ 

create PROCEDURE insertLEADADMIN(
  IN p_name VARCHAR(4000) ,
  IN p_surname VARCHAR(4000) ,
  IN p_email VARCHAR(4000) ,
  IN p_password VARCHAR(4000) ,
  IN p_phone_number VARCHAR(4000) ,
  IN p_address VARCHAR(4000) ,
  IN p_user_name VARCHAR(4000) ,
  IN p_age VARCHAR(4000) )
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;
  /*RAISE;*/
  END;

	INSERT INTO USERS (`NAME`, `SURNAME`, `EMAIL`, `PASSWORD`, `PHONE_NUMBER`, `ADDRESS`, `USER_NAME`, `AGE`)
  VALUES (p_name, p_surname, p_email, p_password, p_phone_number, p_address, p_user_name, p_age);

	INSERT INTO ADMINS (`USER_ID`,`CATEGORY_PERMISSION`)
  VALUES (last_insert_id(),1);

  INSERT INTO LEADADMINS (`USER_ID`,`CATEGORY_COUNT`)
  VALUES (last_insert_id(),0);

  COMMIT;

END$$


DELIMITER ;


drop procedure if exists insertMember;
DELIMITER $$
create PROCEDURE insertMember(
  IN p_name VARCHAR(20) ,
  IN p_surname VARCHAR(20) ,
  IN p_email VARCHAR(30) ,
  IN p_password VARCHAR(100) ,
  IN p_phone_number VARCHAR(11) ,
  IN p_address VARCHAR(200) ,
  IN p_user_name VARCHAR(20) ,
  IN p_age DOUBLE )
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION 
  BEGIN
  	ROLLBACK;
  END;
  

	INSERT INTO USERS (`NAME`, `SURNAME`, `EMAIL`, `PASSWORD`, `PHONE_NUMBER`, `ADDRESS`, `USER_NAME`, `AGE`)
  VALUES (p_name, p_surname, p_email, p_password, p_phone_number, p_address, p_user_name, p_age);

	INSERT INTO MEMBERS (`USER_ID`,`MEMBER_STATUS`, `ANNOUNCEMENT_PERMISSION`)
  VALUES (last_insert_id(),'Active', 1);


  COMMIT;

END$$

DELIMITER ;	


drop procedure if exists insertCATEGORY;

DELIMITER $$
create  PROCEDURE insertCATEGORY(
 IN  p_parent  double,
  IN p_name   VARCHAR(30))

BEGIN
	
  DECLARE EXIT HANDLER FOR SQLEXCEPTION 
  BEGIN
  	ROLLBACK;
  END;
  

  INSERT INTO CATEGORIES (`PARENT_CAT_ID`,`NAME`)
  VALUES (p_parent, p_name);

  COMMIT;

END$$

DELIMITER ;



drop procedure if exists insertPRODUCT;

delimiter $$

create PROCEDURE insertPRODUCT(
  IN p_category double,
  IN p_user double /* Use -meta option PRODUCTS.USER_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option PRODUCTS.NAME%TYPE */,
  IN p_color VARCHAR(4000) /* Use -meta option PRODUCTS.COLOR%TYPE */,
  IN p_mark VARCHAR(4000) /* Use -meta option PRODUCTS.MARK%TYPE */,
  IN p_dimension VARCHAR(4000) /* Use -meta option PRODUCTS.DIMENSION%TYPE */)
BEGIN

  INSERT INTO PRODUCTS (`CATEGORY_ID`, `USER_ID`, `NAME`, `COLOR`, `MARK`, `DIMENSION`)
  VALUES (p_category, p_user, p_name, p_color, p_mark, p_dimension);

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists INSERTWARRANTY;

delimiter $$

create PROCEDURE  INSERTWARRANTY(
  IN p_product double,
  IN p_end_date VARCHAR(4000),
  IN p_start_date VARCHAR(4000))
BEGIN

  INSERT INTO WARRANTIES (`PRODUCT_ID`, `END_DATE`, `START_DATE`)
  VALUES (p_product, STR_TO_DATE(p_end_date, '%d%m%Y'), STR_TO_DATE(p_start_date, '%d%m%Y'));

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists insertWISHLIST;

delimiter $$

create PROCEDURE  INSERTWISHLIST(
  IN p_product double  /* Use -meta option FAVOURITE_PRODUCTS.PRODUCT_ID%TYPE */,
  IN p_user double  /* Use -meta option FAVOURITE_PRODUCTS.USER_ID%TYPE */)
BEGIN

  INSERT INTO WISHLISTS (`PRODUCT_ID`, `USER_ID`)
  VALUES (p_product, p_user);

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists insertCARGOCOMPANY;

delimiter $$

create PROCEDURE INSERTCARGOCOMPANY(
  IN p_name VARCHAR(4000) /* Use -meta option CARGO_COMPANIES.NAME%TYPE */,
  IN p_address VARCHAR(4000) /* Use -meta option CARGO_COMPANIES.ADDRESS%TYPE */,
  IN p_phone VARCHAR(4000) /* Use -meta option CARGO_COMPANIES.PHONE_NUMBER%TYPE */)
BEGIN

  INSERT INTO CARGO_COMPANIES (`NAME`, `ADDRESS`, `PHONE_NUMBER`)
  VALUES (p_name, p_address, p_phone);

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists insertCARGORECORD;

delimiter $$

create PROCEDURE   INSERTCARGORECORD(
  IN p_company double /* Use -meta option CARGO_RECORDS.COMPANY_ID%TYPE */,
  IN p_record double /* Use -meta option CARGO_RECORDS.SALE_RECORD_ID%TYPE */,
  IN p_date VARCHAR(4000))
BEGIN

  INSERT INTO CARGO_RECORDS (`COMPANY_ID`, `SALE_RECORD_ID`, `DATE`)
  VALUES (p_company, p_record, STR_TO_DATE(p_date, '%d%m%Y %H:%i:%s'));

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists insertCOMPLAINT;

delimiter $$

create PROCEDURE insertCOMPLAINT(
  IN p_user double /* Use -meta option COMPLAINTS.USER_ID%TYPE */,
  IN p_text VARCHAR(4000) /* Use -meta option COMPLAINTS.TEXT%TYPE */,
  IN p_subject VARCHAR(4000) /* Use -meta option COMPLAINTS.SUBJECT%TYPE */)
BEGIN

  INSERT INTO COMPLAINTS (`USER_ID`, `DETAILS`, `SUBJECT`)
  VALUES (p_user, p_text, p_subject);

  COMMIT;

END$$


DELIMITER ;

drop procedure if exists insertSALERECORD;

delimiter $$

create PROCEDURE INSERTSALERECORD(
  IN p_product double /* Use -meta option SALE_RECORDS.PRODUCT_ID%TYPE */,
  IN p_announcement double /* Use -meta option SALE_RECORDS.ANNOUNCEMENT_ID%TYPE */,
  IN p_seller double /* Use -meta option SALE_RECORDS.SELLER_ID%TYPE */,
  IN p_buyer double /* Use -meta option SALE_RECORDS.BUYER_ID%TYPE */,
  IN p_cargo_company double,
  IN p_date VARCHAR(4000)
  )
BEGIN

  INSERT INTO SALE_RECORDS (`PRODUCT_ID`, `ANNOUNCEMENT_ID`, `SELLER_ID`, `BUYER_ID`)
  VALUES (p_product, p_announcement, p_seller, p_buyer);
  
  INSERT INTO CARGO_RECORDS(`COMPANY_ID`, `SALE_RECORD_ID`,`DATE`)
  VALUES(p_cargo_company,last_insert_id(), STR_TO_DATE(p_date, '%d%m%Y %H:%i:%s'));
  
  
  UPDATE ANNOUNCEMENTS SET `ANNOUNCEMENT_STATUS`='SOLD' WHERE ANNOUNCEMENT_ID=p_announcement;
COMMIT;
END$$


DELIMITER ;


drop procedure if exists insertSALERECORD2;

delimiter $$

create PROCEDURE INSERTSALERECORD2(
  IN p_product double /* Use -meta option SALE_RECORDS.PRODUCT_ID%TYPE */,
  IN p_announcement double /* Use -meta option SALE_RECORDS.ANNOUNCEMENT_ID%TYPE */,
  IN p_seller double /* Use -meta option SALE_RECORDS.SELLER_ID%TYPE */,
  IN p_buyer double /* Use -meta option SALE_RECORDS.BUYER_ID%TYPE */
  )
BEGIN


  INSERT INTO SALE_RECORDS (`PRODUCT_ID`, `ANNOUNCEMENT_ID`, `SELLER_ID`, `BUYER_ID`)
  VALUES (p_product, p_announcement, p_seller, p_buyer);
  
END$$


DELIMITER ;



drop procedure if exists INSERTANNOUNCEMENT;

delimiter $$

create PROCEDURE INSERTANNOUNCEMENT(
  IN p_category double /* Use -meta option PRODUCTS.CATEGORY_ID%TYPE */,
  IN p_product_name VARCHAR(4000) /* Use -meta option PRODUCTS.NAME%TYPE */,
  IN p_color VARCHAR(4000) /* Use -meta option PRODUCTS.COLOR%TYPE */,
  IN p_mark VARCHAR(4000) /* Use -meta option PRODUCTS.MARK%TYPE */,
  IN p_dimension VARCHAR(4000) /* Use -meta option PRODUCTS.DIMENSION%TYPE */,
  IN p_user double /* Use -meta option ANNOUNCEMENTS.USER_ID%TYPE */,
  IN p_city double /* Use -meta option ANNOUNCEMENTS.CITY_ID%TYPE */,
  IN p_district double /* Use -meta option ANNOUNCEMENTS.DISTRICT_ID%TYPE */,
  IN p_title VARCHAR(4000) /* Use -meta option ANNOUNCEMENTS.TITLE%TYPE */,
  IN p_price VARCHAR(4000) /* Use -meta option ANNOUNCEMENTS.START_PRICE%TYPE */,
  IN p_text VARCHAR(4000) /* Use -meta option ANNOUNCEMENTS.TEXT%TYPE */,
  IN p_start VARCHAR(4000),
  IN p_end VARCHAR(4000),
  IN p_status VARCHAR(4000) /* Use -meta option ANNOUNCEMENTS.STATUS%TYPE */)
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;
  END;
  
	CALL INSERTPRODUCT(p_category, p_user, p_product_name, p_color, p_mark, p_dimension);

  INSERT INTO ANNOUNCEMENTS (`PRODUCT_ID`,`USER_ID`, `CITY_ID`, `DISTRICT_ID`, `TITLE`, `PRICE`,  `DETAILS`, `START_DATE`, `END_DATE`, `ANNOUNCEMENT_STATUS`)
  VALUES (LAST_INSERT_ID(),p_user, p_city, p_district, p_title, p_price, p_text, STR_TO_DATE(p_start, '%d%m%Y %H:%i:%s'), STR_TO_DATE(p_end, '%d%m%Y %H:%i:%s'), p_status);

  COMMIT;


END$$


DELIMITER ;



drop procedure if exists insertDISTRICT;

delimiter $$

create PROCEDURE insertDISTRICT(
  IN p_city double  /* Use -meta option DISTRICTS.CITY_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option DISTRICTS.NAME%TYPE */)
BEGIN

  INSERT INTO DISTRICTS (`CITY_ID`, `NAME`)
  VALUES (p_city, p_name);

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists insertCITY;

delimiter $$

create PROCEDURE insertCITY(
  IN p_name VARCHAR(4000) /* Use -meta option CITIES.NAME%TYPE */)
BEGIN

  INSERT INTO CITIES (`NAME`)
  VALUES (p_name);

  COMMIT;

END$$


DELIMITER ;


drop procedure if exists insertIMAGE;

delimiter $$

create PROCEDURE INSERTIMAGE(
  IN p_announcement double  /* Use -meta option IMAGES.PRODUCT_ID%TYPE */,
  IN p_url VARCHAR(4000) /* Use -meta option IMAGES.URL%TYPE */)
BEGIN

  INSERT INTO IMAGES (PRODUCT_ID, `URL`)
  VALUES (p_announcement, p_url);

  COMMIT;

END$$


DELIMITER ;

drop procedure if exists insertMESSAGE;

delimiter $$ 

create PROCEDURE INSERTMESSAGE(
  IN p_subject VARCHAR(4000) /* Use -meta option MESSAGES.SUBJECT%TYPE */,
  IN p_text VARCHAR(4000) /* Use -meta option MESSAGES.TEXT%TYPE */,
  IN p_to_user VARCHAR(4000) /* Use -meta option MESSAGES.TO_USER%TYPE */,
  IN p_from_user VARCHAR(4000) /* Use -meta option MESSAGES.FROM_USER%TYPE */)
BEGIN

  INSERT INTO MESSAGES (`SUBJECT`, `TEXT`, `TO_USER`, `FROM_USER`)
  VALUES (p_subject, p_text, p_to_user, p_from_user);

  COMMIT;

END$$


DELIMITER ;

drop procedure if exists insertPROCESSINGHISTORY;

delimiter $$

create PROCEDURE INSERTPROCESSINGHISTORY(
  IN p_user double /* Use -meta option PROCESSING_HISTORIES.USER_ID%TYPE */,
  IN p_activity VARCHAR(4000) /* Use -meta option PROCESSING_HISTORIES.ACTIVITY%TYPE */,
  IN p_date VARCHAR(4000))
BEGIN

  INSERT INTO PROCESSING_HISTORIES (`USER_ID`, `ACTIVITY`, `DATE`)
  VALUES (p_user, p_activity, STR_TO_DATE(p_date, '%d%m%Y %H:%i:%s'));

  COMMIT;

END$$


DELIMITER ;


drop procedure if exists updateSUBADMIN;

delimiter $$

create PROCEDURE updateSUBADMIN(
  IN p_userid double  /* Use -meta option USERS.USER_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option USERS.NAME%TYPE */,
  IN p_surname VARCHAR(4000) /* Use -meta option USERS.SURNAME%TYPE */,
  IN p_email VARCHAR(4000) /* Use -meta option USERS.EMAIL%TYPE */,
  IN p_password VARCHAR(4000) /* Use -meta option USERS.PASSWORD%TYPE */,
  IN p_phone_number VARCHAR(4000) /* Use -meta option USERS.PHONE_NUMBER%TYPE */,
  IN p_address VARCHAR(4000) /* Use -meta option USERS.ADDRESS%TYPE */,
  IN p_user_name VARCHAR(4000) /* Use -meta option USERS.USER_NAME%TYPE */,
  IN p_category_permission VARCHAR(4000) /* Use -meta option ADMINS.CATEGORY_PERMISSION%TYPE */)
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;

  /*RAISE;*/
  END;

  UPDATE USERS
  SET `NAME` = p_name,
      `SURNAME` = p_surname,
      `EMAIL` = p_email,
      `PASSWORD` = p_password,
      `PHONE_NUMBER` = p_phone_number,
      `ADDRESS` = p_address,
      `USER_NAME` = p_user_name
  WHERE `USER_ID` = p_userid;

  UPDATE ADMINS
  SET `CATEGORY_PERMISSION` = p_category_permission
  WHERE `USER_ID` = p_userid;

  COMMIT;


END$$


DELIMITER ;



drop procedure if exists deleteSUBADMIN;

delimiter $$

create PROCEDURE deleteSUBADMIN(
  IN p_user_id double  /* Use -meta option SENIOR_ADMINS.USER_ID%TYPE */)
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;

  /*RAISE;*/
  END;

  DELETE FROM SUB_ADMINS
  WHERE p_user_id = USER_ID;

  DELETE FROM ADMINS
  WHERE p_user_id = USER_ID;

  DELETE FROM USERS
  WHERE p_user_id = USER_ID;

  COMMIT;


END$$


DELIMITER ;



drop procedure if exists deleteLEADADMIN;

delimiter $$

create PROCEDURE deleteLEADADMIN(
  IN p_user_id double  /* Use -meta option SENIOR_ADMINS.USER_ID%TYPE */)
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;

  /*RAISE;*/
  END;

  DELETE FROM SENIOR_ADMINS
  WHERE p_user_id = USER_ID;

  DELETE FROM ADMINS
  WHERE p_user_id = USER_ID;

  DELETE FROM USERS
  WHERE p_user_id = USER_ID;

  COMMIT;


END$$


DELIMITER ;



drop procedure if exists updateLEADADMIN;

delimiter $$

create PROCEDURE updateLEADADMIN(
  IN p_userid double /* Use -meta option USERS.USER_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option USERS.NAME%TYPE */,
  IN p_surname VARCHAR(4000) /* Use -meta option USERS.SURNAME%TYPE */,
  IN p_email VARCHAR(4000) /* Use -meta option USERS.EMAIL%TYPE */,
  IN p_password VARCHAR(4000) /* Use -meta option USERS.PASSWORD%TYPE */,
  IN p_phone_number VARCHAR(4000) /* Use -meta option USERS.PHONE_NUMBER%TYPE */,
  IN p_address VARCHAR(4000) /* Use -meta option USERS.ADDRESS%TYPE */,
  IN p_user_name VARCHAR(4000) /* Use -meta option USERS.USER_NAME%TYPE */,
  IN p_category_permission VARCHAR(4000) /* Use -meta option ADMINS.CATEGORY_PERMISSION%TYPE */,
  IN p_category_count VARCHAR(4000) /* Use -meta option SENIOR_ADMINS.CATEGORY_COUNT%TYPE */)
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;

  /*RAISE;*/
  END;

  UPDATE USERS
  SET `NAME` = p_name,
      `SURNAME` = p_surname,
      `EMAIL` = p_email,
      `PASSWORD` = p_password,
      `PHONE_NUMBER` = p_phone_number,
      `ADDRESS` = p_address,
      `USER_NAME` = p_user_name
  WHERE `USER_ID` = p_userid;

  UPDATE ADMINS
  SET `CATEGORY_PERMISSION` = p_category_permission
  WHERE `USER_ID` = p_userid;

  UPDATE SENIOR_ADMINS
  SET `CATEGORY_COUNT` = p_category_count
  WHERE USER_ID = p_userid;

  COMMIT;


END$$


DELIMITER ;



drop procedure if exists updateMEMBER;

delimiter $$

create PROCEDURE updateMEMBER(
  IN p_userid double /* Use -meta option USERS.USER_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option USERS.NAME%TYPE */,
  IN p_surname VARCHAR(4000) /* Use -meta option USERS.SURNAME%TYPE */,
  IN p_email VARCHAR(4000) /* Use -meta option USERS.EMAIL%TYPE */,
  IN p_password VARCHAR(4000) /* Use -meta option USERS.PASSWORD%TYPE */,
  IN p_phone_number VARCHAR(4000) /* Use -meta option USERS.PHONE_NUMBER%TYPE */,
  IN p_address VARCHAR(4000) /* Use -meta option USERS.ADDRESS%TYPE */,
  IN p_user_name VARCHAR(4000) /* Use -meta option USERS.USER_NAME%TYPE */,
  IN p_status VARCHAR(4000) /* Use -meta option MEMBERS.STATUS%TYPE */,
  IN p_announcement_permission VARCHAR(4000) /* Use -meta option MEMBERS.ANNOUNCEMENT_PERMISSION%TYPE */
)
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;

  /*RAISE;*/
  END;

  UPDATE USERS
  SET `NAME` = p_name,
      `SURNAME` = p_surname,
      `EMAIL` = p_email,
      `PASSWORD` = p_password,
      `PHONE_NUMBER` = p_phone_number,
      `ADDRESS` = p_address,
      `USER_NAME` = p_user_name
  WHERE `USER_ID` = p_userid;

  UPDATE MEMBERS
  SET `ANNOUNCEMENT_PERMISSION` = p_announcement_permission,
      `MEMBER_STATUS` = p_status
  WHERE `USER_ID` = p_userid;
/*
  UPDATE PRIMARY_MEMBERS
  SET `ANNOUNCEMENT_COUNT` = p_announcement_count
  WHERE `USER_ID` = p_userid;
*/
  COMMIT;


END$$


DELIMITER ;

drop procedure if exists updateCATEGORY;

delimiter $$

create PROCEDURE updateCATEGORY(
  IN p_category_id double /* Use -meta option CATEGORIES.CATEGORY_ID%TYPE */,
  IN p_parent_cat_id double /* Use -meta option CATEGORIES.PARENT_CAT_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option CATEGORIES.NAME%TYPE */)
BEGIN
  UPDATE CATEGORIES
  SET `PARENT_CAT_ID` = p_parent_cat_id,
      `NAME` = p_name
  WHERE `CATEGORY_ID` = p_category_id;

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updatePRODUCT;

delimiter $$

create PROCEDURE updatePRODUCT(
  IN p_product_id double  /* Use -meta option PRODUCTS.PRODUCT_ID%TYPE */,
  IN p_category double  /* Use -meta option PRODUCTS.CATEGORY_ID%TYPE */,
  IN p_user double /* Use -meta option PRODUCTS.USER_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option PRODUCTS.NAME%TYPE */,
  IN p_color VARCHAR(4000) /* Use -meta option PRODUCTS.COLOR%TYPE */,
  IN p_mark VARCHAR(4000) /* Use -meta option PRODUCTS.MARK%TYPE */,
  IN p_dimension VARCHAR(4000) /* Use -meta option PRODUCTS.DIMENSION%TYPE */)
BEGIN
  UPDATE PRODUCTS
  SET `CATEGORY_ID` = p_category,
      `USER_ID` = p_user,
      `NAME` = p_name,
      `COLOR` = p_color,
      `MARK` = p_mark,
      `DIMENSION` = p_dimension
  WHERE `PRODUCT_ID` = p_product_id AND
        p_category IN (SELECT `CATEGORY_ID` FROM CATEGORIES);

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateWARRANTY;

delimiter $$

create PROCEDURE updateWARRANTY(
  IN p_warranty_id double ,
  IN p_product_id double ,
  IN p_end_date VARCHAR(4000),
  IN p_start_date VARCHAR(4000))
BEGIN
  UPDATE WARRANTIES
  SET `PRODUCT_ID` = p_product_id,
      `END_DATE` = STR_TO_DATE(p_end_date, '%d%m%Y'),
      `START_DATE` = STR_TO_DATE(p_start_date, '%d%m%Y')
  WHERE `WARRANTY_ID` = p_warranty_id AND
        p_product_id IN (SELECT `PRODUCT_ID` FROM PRODUCTS);

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateWISHLIST;

delimiter $$

create PROCEDURE updateWISHLIST(
  IN p_favourite_product_id double /* Use -meta option FAVOURITE_PRODUCTS.FAVOURITE_PRODUCTS_ID%TYPE */,
  IN p_product double /* Use -meta option FAVOURITE_PRODUCTS.PRODUCT_ID%TYPE */,
  IN p_user double  /* Use -meta option FAVOURITE_PRODUCTS.USER_ID%TYPE */)
BEGIN
  UPDATE FAVOURITE_PRODUCTS
  SET `PRODUCT_ID` = p_product,
      `USER_ID` = p_user
  WHERE `FAVOURITE_PRODUCTS_ID` = p_favourite_product_id AND
        p_product IN (SELECT `PRODUCT_ID` FROM PRODUCTS);

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateCARGOCOMPANY;

delimiter $$

create PROCEDURE updateCARGOCOMPANY(
  IN p_company_id double  /* Use -meta option CARGO_COMPANIES.COMPANY_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option CARGO_COMPANIES.NAME%TYPE */,
  IN p_address VARCHAR(4000) /* Use -meta option CARGO_COMPANIES.ADDRESS%TYPE */,
  IN p_phone VARCHAR(4000) /* Use -meta option CARGO_COMPANIES.PHONE_NUMBER%TYPE */)
BEGIN
  UPDATE CARGO_COMPANIES
  SET `NAME` = p_name,
      `ADDRESS` = p_address,
      `PHONE_NUMBER` = p_phone
  WHERE `COMPANY_ID` = p_company_id;

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateCARGORECORD;

delimiter $$

create PROCEDURE updateCARGORECORD(
  IN p_record_id double /* Use -meta option CARGO_RECORDS.RECORD_ID%TYPE */,
  IN p_company double /* Use -meta option CARGO_RECORDS.COMPANY_ID%TYPE */,
  IN p_record double /* Use -meta option CARGO_RECORDS.SALE_RECORD_ID%TYPE */,
  IN p_date VARCHAR(4000))
BEGIN
  UPDATE CARGO_RECORDS
  SET `COMPANY_ID` = p_company,
      `SALE_RECORD_ID` = p_record,
      `DATE` = STR_TO_DATE(p_date, '%d%m%Y %H:%i:%s')
  WHERE `CARGO_RECORD_ID` = p_record_id AND
        p_company IN (SELECT `COMPANY_ID` FROM CARGO_COMPANIES) AND
        p_record IN (SELECT `SALE_RECORD_ID` FROM SALE_RECORDS);

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateCOMPLAINT;

delimiter $$

create PROCEDURE updateCOMPLAINT(
  IN p_complaint_id double  /* Use -meta option COMPLAINTS.COMPLAINT_ID%TYPE */,
  IN p_user double  /* Use -meta option COMPLAINTS.USER_ID%TYPE */,
  IN p_text VARCHAR(4000) /* Use -meta option COMPLAINTS.TEXT%TYPE */,
  IN p_subject VARCHAR(4000) /* Use -meta option COMPLAINTS.SUBJECT%TYPE */)
BEGIN
  UPDATE COMPLAINTS
  SET `USER_ID` = p_user,
      `TEXT` = p_text,
      `SUBJECT` = p_subject
  WHERE `COMPLAINT_ID` = p_complaint_id AND
        p_user IN (SELECT `USER_ID` FROM USERS);

  COMMIT;
END$$


DELIMITER ;

drop procedure if exists updateSALERECORD;

delimiter $$

create PROCEDURE updateSALERECORD(
  IN p_record_id double /* Use -meta option SALE_RECORDS.RECORD_ID%TYPE */,
  IN p_product double /* Use -meta option SALE_RECORDS.PRODUCT_ID%TYPE */,
  IN p_announcement double /* Use -meta option SALE_RECORDS.ANNOUNCEMENT_ID%TYPE */,
  IN p_seller double /* Use -meta option SALE_RECORDS.SELLER_ID%TYPE */,
  IN p_buyer double /* Use -meta option SALE_RECORDS.BUYER_ID%TYPE */)
BEGIN
  UPDATE SALE_RECORDS
  SET `PRODUCT_ID` = p_product,
      `ANNOUNCEMENT_ID` = p_announcement,
      `SELLER_ID` = p_seller,
      `BUYER_ID` = p_buyer
  WHERE `RECORD_ID` = p_record_id AND
        p_product IN (SELECT `PRODUCT_ID` FROM PRODUCTS) AND
        p_announcement IN (SELECT `ANNOUNCEMENT_ID` FROM ANNOUNCEMENTS) AND
        p_seller IN (SELECT `USER_ID` FROM USERS) AND
        p_buyer IN (SELECT `USER_ID` FROM USERS);

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateANNOUNCEMENT;

delimiter $$

create PROCEDURE updateANNOUNCEMENT(
  IN p_announcement double /* Use -meta option ANNOUNCEMENTS.ANNOUNCEMENT_ID%TYPE */,
  IN p_product double  /* Use -meta option ANNOUNCEMENTS.PRODUCT_ID%TYPE */,
  IN p_user double  /* Use -meta option ANNOUNCEMENTS.USER_ID%TYPE */,
  IN p_city double  /* Use -meta option ANNOUNCEMENTS.CITY_ID%TYPE */,
  IN p_district double  /* Use -meta option ANNOUNCEMENTS.DISTRICT_ID%TYPE */,
  IN p_title VARCHAR(4000) /* Use -meta option ANNOUNCEMENTS.TITLE%TYPE */,
  IN p_text VARCHAR(4000) /* Use -meta option ANNOUNCEMENTS.TEXT%TYPE */,
  IN p_start VARCHAR(4000),
  IN p_end VARCHAR(4000),
  IN p_status VARCHAR(4000) /* Use -meta option ANNOUNCEMENTS.STATUS%TYPE */)
BEGIN
  UPDATE ANNOUNCEMENTS
  SET `PRODUCT_ID` = p_product,
      `USER_ID` = p_user,
      `CITY_ID` = p_city,
      `DISTRICT_ID` = p_district,
      `TITLE` = p_title,
      `TEXT` = p_text,
      `START_DATE` = STR_TO_DATE(p_start, '%d%m%Y %H:%i:%s'),
      `END_DATE` = STR_TO_DATE(p_end, '%d%m%Y %H:%i:%s'),
      `ANNOUNCEMENT_STATUS` = p_status
  WHERE `ANNOUNCEMENT_ID` = p_announcement AND
        p_product IN (SELECT `PRODUCT_ID` FROM PRODUCTS) AND
        p_user IN (SELECT `USER_ID` FROM USERS) AND
        p_city IN (SELECT `CITY_ID` FROM CITIES) AND
        p_district IN (SELECT `DISTRICT_ID` FROM DISTRICTS);

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateDISTRICT;

delimiter $$

create PROCEDURE updateDISTRICT(
  IN p_district double  /* Use -meta option DISTRICTS.DISTRICT_ID%TYPE */,
  IN p_city double  /* Use -meta option DISTRICTS.CITY_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option DISTRICTS.NAME%TYPE */)
BEGIN
  UPDATE DISTRICTS
  SET `CITY_ID` = p_city,
      `NAME` = p_name
  WHERE `DISTRICT_ID` = p_district AND
        p_city IN (SELECT `CITY_ID` FROM CITIES);

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateCITY;

delimiter $$

create PROCEDURE updateCITY(
  IN p_city double  /* Use -meta option CITIES.CITY_ID%TYPE */,
  IN p_name VARCHAR(4000) /* Use -meta option CITIES.NAME%TYPE */)
BEGIN
  UPDATE CITIES
  SET `NAME` = p_name
  WHERE `CITY_ID` = p_city;

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updateIMAGE;

delimiter $$

create PROCEDURE updateIMAGE(
  IN p_image double  /* Use -meta option IMAGES.IMAGE_ID%TYPE */,
  IN p_announcement double  /* Use -meta option IMAGES.PRODUCT_ID%TYPE */,
  IN p_url VARCHAR(4000) /* Use -meta option IMAGES.URL%TYPE */)
BEGIN
  UPDATE IMAGES
  SET PRODUCT_ID = p_announcement,
      `URL` = p_url
  WHERE `IMAGE_ID` = p_image AND
        p_announcement IN (SELECT PRODUCT_ID FROM ANNOUNCEMENTS);

  COMMIT;
END$$


DELIMITER ;



drop procedure if exists updatePROCESSINGHISTORY;

delimiter $$ 

create PROCEDURE updatePROCESSINGHISTORY(
  IN p_processing_history double /* Use -meta option PROCESSING_HISTORIES.PROCESSING_HISTORY_ID%TYPE */,
  IN p_user double  /* Use -meta option PROCESSING_HISTORIES.USER_ID%TYPE */,
  IN p_activity VARCHAR(4000) /* Use -meta option PROCESSING_HISTORIES.ACTIVITY%TYPE */,
  IN p_date VARCHAR(4000))
BEGIN
  UPDATE PROCESSING_HISTORIES
  SET `USER_ID` = p_user,
      `ACTIVITY` = p_activity,
      `DATE` = STR_TO_DATE(p_date, '%d%m%Y %H:%i:%s')
  WHERE `PROCESSING_HISTORY_ID` = p_processing_history AND
        p_user IN (SELECT `USER_ID` FROM USERS);

  COMMIT;
END$$

DELIMITER ;



drop procedure if exists deleteANNOUNCEMENT;

delimiter $$

create PROCEDURE deleteANNOUNCEMENT(
  IN p_announcement_id double  /* Use -meta option ANNOUNCEMENTS.ANNOUNCEMENT_ID%TYPE */)
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;

  /*RAISE;*/
  END;

  DELETE FROM ANNOUNCEMENTS
  WHERE p_announcement_id = ANNOUNCEMENT_ID;

  DELETE FROM PRODUCTS
  WHERE P.PRODUCT_ID IN (
    SELECT A.PRODUCT_ID FROM ANNOUNCEMENTS A WHERE p_announcement_id = A.ANNOUNCEMENT_ID);

  COMMIT;

END$$


DELIMITER ;

drop procedure if exists deleteCARGOCOMPANY;

delimiter $$

create PROCEDURE deleteCARGOCOMPANY(
  IN p_company_id double  /* Use -meta option CARGO_COMPANIES.COMPANY_ID%TYPE */)
BEGIN

  DELETE FROM CARGO_COMPANIES
  WHERE p_company_id = COMPANY_ID;

  COMMIT;

END$$


DELIMITER ;


drop procedure if exists deleteCARGORECORD;

delimiter $$

create PROCEDURE deleteCARGORECORD(
  IN p_record_id double  /* Use -meta option CARGO_RECORDS.RECORD_ID%TYPE */)
BEGIN

  DELETE FROM CARGO_RECORDS
  WHERE p_record_id = CARGO_RECORD_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteCATEGORY;

delimiter $$

create PROCEDURE deleteCATEGORY(
  IN p_category_id double  /* Use -meta option CATEGORIES.CATEGORY_ID%TYPE */)
BEGIN

  DELETE FROM CATEGORIES
  WHERE p_category_id = CATEGORY_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteCITY;

delimiter $$

create PROCEDURE deleteCITY(
  IN p_city_id double   /* Use -meta option CITIES.CITY_ID%TYPE */)
BEGIN

  DELETE FROM CITIES
  WHERE p_city_id = CITY_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteCOMPLAINT;

delimiter $$

create PROCEDURE deleteCOMPLAINT(
  IN p_complaint_id double  /* Use -meta option COMPLAINTS.COMPLAINT_ID%TYPE */)
BEGIN

  DELETE FROM COMPLAINTS
  WHERE p_complaint_id = COMPLAINT_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteDISTRICT;

delimiter $$

create PROCEDURE deleteDISTRICT(
  IN p_district_id double  /* Use -meta option DISTRICTS.DISTRICT_ID%TYPE */)
BEGIN

  DELETE FROM DISTRICTS
  WHERE p_district_id = DISTRICT_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteFAVOURITEPRODUCT;

delimiter $$

create PROCEDURE deleteFAVOURITEPRODUCT(
  IN p_product_id double /* Use -meta option FAVOURITE_PRODUCTS.PRODUCT_ID%TYPE */,
  IN p_user_id double  /* Use -meta option FAVOURITE_PRODUCTS.USER_ID%TYPE */)
BEGIN

  DELETE FROM FAVOURITE_PRODUCTS
  WHERE p_product_id = PRODUCT_ID AND p_user_id = USER_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteWARRANTY;

delimiter $$

create PROCEDURE deleteWARRANTY(
  IN p_warranty_id double)
BEGIN

  DELETE FROM WARRANTIES
  WHERE p_warranty_id = WARRANTY_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteIMAGE;

delimiter $$

create PROCEDURE deleteIMAGE(
  IN p_image_id double  /* Use -meta option IMAGES.IMAGE_ID%TYPE */)
BEGIN

  DELETE FROM IMAGES
  WHERE p_image_id = IMAGE_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteOFFER;

delimiter $$

create PROCEDURE deleteOFFER(
  IN p_offer_id double  /* Use -meta option OFFERS.OFFER_ID%TYPE */)
BEGIN

  DELETE FROM OFFERS
  WHERE p_offer_id = OFFER_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteMEMBER;

delimiter  $$

create PROCEDURE deleteMEMBER(
  IN p_user_id double  /* Use -meta option PRIMARY_MEMBERS.USER_ID%TYPE */)
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
  ROLLBACK;

 
  END;

  

  DELETE FROM MEMBERS
  WHERE p_user_id = USER_ID;

  DELETE FROM USERS
  WHERE p_user_id = USER_ID;

  COMMIT;


END$$


DELIMITER ;



drop procedure if exists deletePROCESSINGHISTORY;

delimiter $$

create PROCEDURE deletePROCESSINGHISTORY(
  IN p_history_id double  /* Use -meta option PROCESSING_HISTORIES.PROCESSING_HISTORY_ID%TYPE */)
BEGIN

  DELETE FROM PROCESSING_HISTORIES
  WHERE p_history_id = PROCESSING_HISTORY_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deletePRODUCT;

delimiter $$

create PROCEDURE deletePRODUCT(
  IN p_product_id double  /* Use -meta option PRODUCTS.PRODUCT_ID%TYPE */)
BEGIN

  DELETE FROM PRODUCTS
  WHERE p_product_id = PRODUCT_ID;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteSALERECORD;

delimiter $$

create PROCEDURE deleteSALEROCORD(
  IN p_record_id double  /* Use -meta option SALE_RECORDS.RECORD_ID%TYPE */)
BEGIN

  DELETE FROM SALE_RECORDS
  WHERE p_record_id = RECORD_ID;

  COMMIT;

END$$


DELIMITER ;

drop procedure if exists updateMESSAGE;

delimiter $$

create PROCEDURE updateMESSAGE(
  IN p_message_id  double /* Use -meta option MESSAGES.MESSAGE_ID%TYPE */,
  IN p_subject VARCHAR(4000) /* Use -meta option MESSAGES.SUBJECT%TYPE */,
  IN p_text VARCHAR(4000) /* Use -meta option MESSAGES.TEXT%TYPE */,
  IN p_to_user VARCHAR(4000) /* Use -meta option MESSAGES.TO_USER%TYPE */,
  IN p_from_user VARCHAR(4000) /* Use -meta option MESSAGES.FROM_USER%TYPE */)
BEGIN

  UPDATE MESSAGES
  SET `SUBJECT` = p_subject,
      `TEXT` = p_text,
      `TO_USER` = p_to_user,
      `FROM_USER` = p_from_user
  WHERE `MESSAGE_ID` = p_message_id AND
        p_to_user IN (SELECT `USER_ID` FROM USERS) AND
        p_from_user IN (SELECT `USER_ID` FROM USERS);

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists deleteMESSAGE;

delimiter $$

create PROCEDURE deleteMESSAGE(
  IN p_message_id double  /* Use -meta option MESSAGES.MESSAGE_ID%TYPE */)
  BEGIN

    DELETE FROM MESSAGES
    WHERE p_message_id = MESSAGE_ID;

    COMMIT;

  END$$

DELIMITER ;



drop procedure if exists increaseCATEGORYCOUNT;

delimiter $$

create PROCEDURE increaseCATEGORYCOUNT(
  IN p_userid double   /* Use -meta option SENIOR_ADMINS.USER_ID%TYPE */
)
BEGIN

  UPDATE LEADADMINS
  SET `CATEGORY_COUNT` = `CATEGORY_COUNT` + 1
  WHERE USER_ID = p_userid;

  COMMIT;

END$$


DELIMITER ;



drop procedure if exists increaseANNOUNCEMENTCOUNT;

delimiter $$

create PROCEDURE increaseANNOUNCEMENTCOUNT(
  IN p_userid double  /* Use -meta option PRIMARY_MEMBERS.USER_ID%TYPE */
)
BEGIN

  UPDATE  MEMBERS
  SET `ANNOUNCEMENT_COUNT` = `ANNOUNCEMENT_COUNT` + 1
  WHERE USER_ID = p_userid;

  COMMIT;

END$$


DELIMITER ;


drop procedure if exists updateMEMBERSTATUS;

delimiter $$

create PROCEDURE updateMEMBERSTATUS(
  IN p_userid double  /* Use -meta option MEMBERS.USER_ID%TYPE */,
  IN p_status VARCHAR(4000) /* Use -meta option MEMBERS.STATUS%TYPE */
)
BEGIN

  UPDATE MEMBERS
  SET `MEMBER_STATUS` = p_status
  WHERE USER_ID = p_userid;

  COMMIT;

END$$


DELIMITER ;




