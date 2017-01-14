DROP TABLE IF EXISTS OrderLines;

CREATE TABLE  OrderLines(
  OrderID int(11) NOT NULL,
  TyreID int(11) NOT NULL,
  Quantity int(11) default '1',
  Cost double NOT NULL,
  CostWithVAT double NOT NULL,
  ReplyCode int(11) NOT NULL default '255',
  PRIMARY KEY  (OrderID,TyreID),
  KEY FK_OrderLines_TyreID (TyreID),
  CONSTRAINT FK_OrderLines_OrderID FOREIGN KEY (OrderID) REFERENCES OrderHeader (OrderID),
  CONSTRAINT FK_OrderLines_TyreID FOREIGN KEY (TyreID) REFERENCES Tyres (TyreID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;