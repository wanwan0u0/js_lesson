BEGIN;

DROP TABLE IF EXISTS order_artwork_detail;
DROP TABLE IF EXISTS order_ticket_detail;
DROP TABLE IF EXISTS collection_detail;
DROP TABLE IF EXISTS exhibition_detail;
DROP TABLE IF EXISTS oorder;
DROP TABLE IF EXISTS artwork;
DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS exhibition;
DROP TABLE IF EXISTS uuser ;

CREATE TABLE uuser (
    user_ID INT AUTO_INCREMENT,
    user_name VARCHAR(50) NOT NULL,
    user_introduce VARCHAR(200),
    user_introduce_html VARCHAR(200),
    user_account CHAR(10) NOT NULL,
    user_email VARCHAR(50) NOT NULL,
    user_password VARCHAR(20) NOT NULL,
    user_enroll_date DATE NOT NULL,
    user_role VARCHAR(10) NOT NULL,
    user_icon VARCHAR(50),
    PRIMARY KEY (user_ID)
);



CREATE TABLE oorder (
    order_ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    order_total_number VARCHAR(35) NOT NULL,
    order_total_price DECIMAL(10, 2) NOT NULL,
    order_datetime DATETIME NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES uuser(user_id)
);


CREATE TABLE exhibition (
  exhibition_ID INTEGER NOT NULL AUTO_INCREMENT,
  exhibition_name VARCHAR(50) NOT NULL,
  exhibition_introduce VARCHAR(1000) NOT NULL,
  exhibition_start_time DATETIME NOT NULL,
  exhibition_end_time DATETIME NOT NULL,
  exhibition_place VARCHAR(50),
  exhibition_price DECIMAL(10, 2),
  exhibition_alert BOOLEAN NOT NULL,
  exhibition_status VARCHAR(20) NOT NULL,
  PRIMARY KEY (exhibition_ID)
);

CREATE TABLE artwork (
    artwork_ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    artwork_name VARCHAR(50) NOT NULL,
    artwork_price DECIMAL(10, 2),
    artwork_information VARCHAR(200),
    artwork_information_html VARCHAR(200),
    artwork_stock INT,
    artwork_class VARCHAR(50) NOT NULL,
    artwork_type VARCHAR(50) NOT NULL,
    artwork_file VARCHAR(50),
    user_id INT,
    exhibition_ID INT,
    FOREIGN KEY (user_id) REFERENCES uuser(user_id),
    FOREIGN KEY (exhibition_ID) REFERENCES exhibition(exhibition_ID)
    
);




CREATE TABLE ticket (
  ticket_ID INTEGER PRIMARY KEY AUTO_INCREMENT,
  ticket_stock INT NOT NULL,
  exhibition_ID INT,
  FOREIGN KEY (exhibition_ID) REFERENCES exhibition(exhibition_ID)
);


CREATE TABLE collection_detail (
  user_ID INTEGER,
  artwork_ID INTEGER,
  PRIMARY KEY (user_ID, artwork_ID),
  FOREIGN KEY (user_ID) REFERENCES uuser(user_ID),
  FOREIGN KEY (artwork_ID) REFERENCES artwork(artwork_ID)
);



CREATE TABLE exhibition_detail (
  user_ID INT,
  exhibition_ID INT,
  exhibition_date DATE,
  exhibition_time TIME,
  PRIMARY KEY (user_ID, exhibition_ID),
  FOREIGN KEY (user_ID) REFERENCES uuser(user_ID),
  FOREIGN KEY (exhibition_ID) REFERENCES exhibition(exhibition_ID)
);

CREATE TABLE order_artwork_detail (
    artwork_ID INT,
    order_ID INT,
    OAD_Quantity INT,
    OAD_Amount DECIMAL(10, 2),
    OAD_status BOOLEAN NOT NULL,
    PRIMARY KEY (artwork_ID, order_ID),
    FOREIGN KEY (artwork_ID) REFERENCES artwork(artwork_ID),
    FOREIGN KEY (order_ID) REFERENCES oorder(order_ID)
);

CREATE TABLE order_ticket_detail (
    ticket_ID INT,
    order_ID INT,
    OTD_Quantity INT,
    OTD_Amount DECIMAL(10, 2),
    OTD_status BOOLEAN NOT NULL,
    Ticket_information VARCHAR(50),
    PRIMARY KEY (ticket_ID, order_ID),
    FOREIGN KEY (ticket_ID) REFERENCES ticket(ticket_ID),
    FOREIGN KEY (order_ID) REFERENCES oorder(order_ID)
);

INSERT INTO `uuser` (`user_ID`, `user_name`, `user_introduce`,`user_introduce_html`, `user_account`, `user_email`, `user_password`, `user_enroll_date`, `user_role`,`user_icon`) VALUES ('1', 'wanwan', 'wanwan is the best ai artist','wanwan is the best artist(html)', 'wanwan', 'wanwan@gmail.com', '123456', '2023-05-26', 'artist', '01731.png');
INSERT INTO `uuser` (`user_ID`, `user_name`, `user_introduce`,`user_introduce_html`, `user_account`, `user_email`, `user_password`, `user_enroll_date`, `user_role`,`user_icon`) VALUES ('2', 'wanwan2', 'wanwan is the admin.','wanwan2 is the best artist(html)', 'wanwan2', 'wanwan2@gmail.com', '123456', '2023-05-26', 'admin', '01731.png');
INSERT INTO `uuser` (`user_ID`, `user_name`, `user_introduce`,`user_introduce_html`, `user_account`, `user_email`, `user_password`, `user_enroll_date`, `user_role`,`user_icon`) VALUES ('3', 'wanwan3', 'wanwan is the collector.','wanwan3 is the best collector(html)', 'wanwan3', 'wanwan3@gmail.com', '123456', '2023-05-26', 'collector', '01731.png');

INSERT INTO `oorder` (`order_ID`, `order_total_number`, `order_total_price`, `order_datetime`, `user_id`)
VALUES ('1', '1', '500', '2023-05-26', '1');
INSERT INTO `oorder` (`order_ID`, `order_total_number`, `order_total_price`, `order_datetime`, `user_id`)
VALUES ('2', '1', '200', '2023-05-26', '3');

INSERT INTO `exhibition` (`exhibition_ID`, `exhibition_name`, `exhibition_introduce`, `exhibition_start_time`, `exhibition_end_time`, `exhibition_place`, `exhibition_price`,`exhibition_status`,`exhibition_alert`)
VALUES ('1', 'Wanwan ai artwork', 'The best ai artwork show!', '2023-05-26', '2023-05-30', 'library 2nd floor', '200','進行中','0');

INSERT INTO `artwork` (`artwork_ID`, `artwork_name`, `artwork_price`, `artwork_information`, `artwork_information_html`,`artwork_stock`, `artwork_class`, `artwork_type`, `artwork_file`, `user_id`)
VALUES ('1', 'black dress in hall', '100.00', '01731','black dress in hall(html)', '3', '周邊商品', '萬哥公仔', '01731.png', '1');

INSERT INTO `artwork` (`artwork_ID`, `artwork_name`, `artwork_price`, `artwork_information`, `artwork_information_html`, `artwork_stock`, `artwork_class`, `artwork_type`, `artwork_file`, `user_id`)
VALUES ('2', 'singer','200.00', '01858','singer(html)' , '3', '周邊商品', '萬哥明信片', '01858.png', '1');

INSERT INTO `artwork` (`artwork_ID`, `artwork_name`, `artwork_price`, `artwork_information`, `artwork_information_html`, `artwork_stock`, `artwork_class`, `artwork_type`, `artwork_file`, `user_id`)
VALUES ('3', 'girl','300.00', '01879.png','singer(html)', '3', '周邊商品', '萬哥鑰匙圈', '01879.png', '1');

INSERT INTO `artwork` (`artwork_ID`, `artwork_name`, `artwork_price`, `artwork_information`, `artwork_information_html`, `artwork_class`, `artwork_type`, `artwork_file`, `user_id`,`exhibition_id`)
VALUES ('4', 'No.4','300.00', 'Fw8QJhhacAAoFV9.jfif','singer(html)', '藝術家創作', '萬哥創作', 'Fw8QJhhacAAoFV9.jfif', '1','1');

INSERT INTO `artwork` (`artwork_ID`, `artwork_name`, `artwork_price`, `artwork_information`, `artwork_information_html`, `artwork_class`, `artwork_type`, `artwork_file`, `user_id`,`exhibition_id`)
VALUES ('5', 'No.5','300.00', 'Fw6B0aTaIAEEDq4.jfif','singer(html)', '藝術家創作', '萬哥創作', 'Fw6B0aTaIAEEDq4.jfif', '1','1');

INSERT INTO `ticket` (`ticket_ID`, `ticket_stock`, `exhibition_ID`)
VALUES ('1', '200', '1');

INSERT INTO `collection_detail` (`user_ID`, `artwork_ID`)
VALUES ('1', '4');

INSERT INTO `exhibition_detail` (`user_ID`, `exhibition_ID`, `exhibition_date`, `exhibition_time`)
VALUES ('1', '1', '2023-05-28', '14:00');

INSERT INTO `order_artwork_detail` (`artwork_ID`, `order_ID`, `OAD_Quantity`, `OAD_Amount`, `OAD_status`)
VALUES ('1', '1', '1', '100','0');

INSERT INTO `order_ticket_detail` (`ticket_ID`, `order_ID`, `OTD_Quantity`, `OTD_Amount`, `OTD_status`, `ticket_information`)
VALUES ('1', '2', '1', '200','1','information');



COMMIT;
