create database sweetchat;
use sweetchat;

create table users (
	userid int(18) not null auto_increment,
	firstname varchar(50) not null,
	lastname varchar(50),
	username varchar(50) not null,
	email varchar(50) not null,
	password varchar(250) not null,
	regdate datetime not null default current_timestamp,
	lastupdated datetime not null default current_timestamp on update current_timestamp,
	primary key(userid)
);

create table status (
	statusid int(18) not null auto_increment,
	type varchar(50) not null,
	primary key(statusid)
);

create table relationships (
	userid_1 int(18) not null,
	userid_2 int(18) not null,
	statusid int(18) not null,
	primary key(userid_1, userid_2)
);

create table messages (
	messageid int(18) not null auto_increment,
	senton datetime not null default current_timestamp,
	text varchar(2000) not null,
	chatid int(18) not null,
	userid int(18) not null,
	primary key(messageid)
);

create table chatusers (
	chatid int(18) not null,
	userid int(18) not null,
	primary key(chatid, userid)
);

create table chats (
	chatid int(18) not null auto_increment,
	topic varchar(50) not null default 'SweetChat',
	color char(7) not null default '#cc00ff',
	userid int(18) not null,
	createdon datetime not null default current_timestamp,
	primary key(chatid)
);

alter table relationships add foreign key relationships_ibfk_1 (statusid) references status(statusid) on delete cascade;
alter table messages add foreign key messages_ibfk_1 (chatid) references chats(chatid) on delete cascade;
alter table messages add foreign key messages_ibfk_2 (userid) references users(userid) on delete cascade;
alter table chatusers add foreign key chatusers_ibfk_1 (userid) references users(userid) on delete cascade;
alter table chatusers add foreign key chatusers_ibfk_2 (chatid) references chats(chatid) on delete cascade;
alter table chats add foreign key chats_ibfk_1 (userid) references users(userid) on delete cascade;

/*
foreign keys are added to establish parent-child relationships
for example in the above tables, the 'users' table is the parent while chatusers is a child
(similarly 'chats' table is a parent while 'chatusers' is its child)
because an entry in the child points/links/references to a specific entry in the parent. Now if this 
entry in the child is deleted, the corresponding parent entry will not be affected but if
the parent entry is deleted the linked child entries must be deleted (obviously it will make no sense
to store the chats of a user who has been deleted) and it will be done so if the 'on delete cascade'
attribute was provided, if it was not provided then this will raise an error.
*/


