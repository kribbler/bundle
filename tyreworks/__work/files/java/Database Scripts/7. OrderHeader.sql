DROP  Table IF EXISTS OrderHeaderAudit;
DROP Table  IF EXISTS OrderLines;
DROP Table  IF EXISTS OrderHeader;

CREATE TABLE  OrderHeader (
  OrderID int(11) NOT NULL auto_increment,
  ServerID int(11) NOT NULL,
  UserID varchar(50) NOT NULL,
  PriceList int(11) default NULL,
  DealerID int(11) default NULL,
  Title varchar(10) default NULL,
  cusFname varchar(30) default NULL,
  cusLname varchar(30) default NULL,
  billAddr1 varchar(30) default NULL,
  billAddr2 varchar(30) default NULL,
  billAddr3 varchar(30) default NULL,
  billAddr4 varchar(30) default NULL,
  billPcode varchar(12) default NULL,
  billPhone varchar(15) default NULL,
  billMobile varchar(15) default NULL,
  delvTitle varchar(5) default NULL,
  delvFName varchar(30) default NULL,
  delvLName varchar(25) default NULL,
  delvAddr1 varchar(30) default NULL,
  delvAddr2 varchar(30) default NULL,
  delvAddr3 varchar(30) default NULL,
  delvAddr4 varchar(30) default NULL,
  delvPcode varchar(12) default NULL,
  delvPhone varchar(15) default NULL,
  RegNum varchar(10) default NULL,
  FittingDate datetime default NULL,
  isAM bit(1) default NULL,
  Comments varchar(500) default NULL,
  AuthCode varchar(20) default NULL,
  LastUpdate datetime default NULL,
  PaymentTaken bit(1) NOT NULL default '\0',
  EmailSent bit(1) NOT NULL default '\0',
  MidasOrderID int(11) NOT NULL default '-1',
  ReadAttempts int(11) NOT NULL default '0',
  PasRef varchar(40) default NULL,
  PRIMARY KEY  (OrderID),
  KEY FK_OrderHeader_DealerID (DealerID),
  CONSTRAINT FK_OrderHeader_DealerID FOREIGN KEY (DealerID) REFERENCES Dealers (DealerID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;