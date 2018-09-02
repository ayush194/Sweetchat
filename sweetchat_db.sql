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

alter table relationships add foreign key relationships_statusid_fk (statusid) references status(statusid);
alter table messages add foreign key messages_chatid_fk (chatid) references chats(chatid);
alter table messages add foreign key messages_userid_fk (userid) references users(userid);
alter table chatusers add foreign key chatusers_userid_fk (userid) references users(userid);
alter table chatusers add foreign key chatusers_chatid_fk (chatid) references chats(chatid);
alter table chats add foreign key chats_userid_fk (userid) references users(userid);



