drop database if exists データベース名;
create database データベース名 default character set utf8;
drop user if exists 'ユーザー名'@'localhost';
create user 'ユーザー名'@'localhost' identified by 'パスワード';
grant all on データベース名.* to 'ユーザー名'@'localhost';
use データベース名;

create table store (
	store_id int auto_increment primary key, 
	store_name varchar(200) not null, 
	store_password varchar(100) not null
);

create table customer (
	customer_id int auto_increment primary key, 
	name varchar(100) not null, 
	reading varchar(200) not null, 
	age int not null, 
	telephone_number bigint not null,
    details varchar(300)
);

create table order_menu (
	id int auto_increment not null primary key, 
	customer_id int not null,
    FOREIGN KEY (customer_id) REFERENCES customer (customer_id)  ON DELETE CASCADE ON UPDATE CASCADE,
    store_id int not null,
    FOREIGN KEY (store_id) REFERENCES store (store_id)  ON DELETE CASCADE ON UPDATE CASCADE,
	order_details varchar(300) not null,
    date DATE not null
);

INSERT INTO `customer` (`customer_id`, `name`, `reading`, `age`, `telephone_number`, `details`) VALUES (NULL, '太郎', 'タロウ', '20', '07084562856', '太郎さんの詳細');
INSERT INTO `customer` (`customer_id`, `name`, `reading`, `age`, `telephone_number`, `details`) VALUES (NULL, '次郎', 'ジロウ', '20', '07084562856', '次郎さんの詳細');
INSERT INTO `customer` (`customer_id`, `name`, `reading`, `age`, `telephone_number`, `details`) VALUES (NULL, '三郎', 'サブロウ', '20', '07084562856', '三郎さんの詳細');

INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '1', '1', '1度目の来店です。356番のメニューをオーダー', '2023-04-12 08:48:17.000000');
INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '1', '1', '2度目の来店です。643番のメニューをオーダー', '2023-04-12 08:48:17.000000');
INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '1', '1', '3度目の来店です。631番のメニューをオーダー', '2023-04-12 08:48:17.000000');
INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '2', '1', '1度目の来店です。754番のメニューをオーダー', '2023-04-12 08:48:17.000000');
INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '2', '1', '2度目の来店です。123番のメニューをオーダー', '2023-04-12 08:48:17.000000');
INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '2', '1', '3度目の来店です。975番のメニューをオーダー', '2023-04-12 08:48:17.000000');
INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '3', '1', '1度目の来店です。005番のメニューをオーダー', '2023-04-12 08:48:17.000000');
INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '3', '1', '2度目の来店です。588番のメニューをオーダー', '2023-04-12 08:48:17.000000');
INSERT INTO `order_menu` (`id`, `customer_id`, `store_id`, `order_details`, `date`) VALUES (NULL, '3', '1', '3度目の来店です。867番のメニューをオーダー', '2023-04-12 08:48:17.000000');