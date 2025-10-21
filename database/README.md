To create table userdata for database habits:  
go to localhost/phpmyadmin
On left, click new, then database habits.
Click SQL, paste:
```
CREATE TABLE  userdata  (
  id  int NOT NULL,
  username  varchar(45) NOT NULL,
  type  varchar(45) NOT NULL,
  text  varchar(255) NOT NULL,
 PRIMARY KEY ( username, id, type )
)
```

Same process for users database:
```
CREATE TABLE  userdata  (
  id  int NOT NULL AUTO_INCREMENT,
  username  varchar(45) NOT NULL,
  password  varchar(45) NOT NULL,
 PRIMARY KEY ( id ),
 UNIQUE KEY  id_UNIQUE  ( id )
)
```
