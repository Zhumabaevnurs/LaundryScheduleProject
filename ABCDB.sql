create database CSC350GroupCTerm;

create table CSC350GroupCTerm.UserInfo
(
USERID varchar(45)  not null,
PASSWORD varchar(45)  not null,
FIRSTNAME varchar(45)  not null,
LASTNAME varchar(45)  not null,
EMAIL varchar(45)  not null,
PHONE varchar(10)  not null,
APT varchar(2)  not null,
primary key(USERID),
key APT (APT)
);

create table CSC350GroupCTerm.Schedule
(
SESSIONID int not null,
APT varchar(2)  not null,
USEDATE datetime not null,
primary key(SESSIONID),
foreign key(APT) references UserInfo (APT)
);