DROP  Table IF EXISTS Quantity;

CREATE TABLE Quantity
(
   TyreID		int NOT NULL,
   SiteID		int NOT NULL,
   CusID		int NOT NULL,
   Qty		smallint NULL,
   UpdatedDate     datetime    NULL,
   LastUpdated datetime        NULL,
   
   PRIMARY KEY (TyreID, SiteID, CusID),

KEY FK_Quantity_TyreID (TyreID),
  CONSTRAINT FK_Quantity_TyreID FOREIGN KEY (TyreID) REFERENCES Tyres (TyreID),
CONSTRAINT FK_Quantity_CusID FOREIGN KEY (CusID) REFERENCES Dealers (DealerID)


) ENGINE=InnoDB DEFAULT CHARSET=latin1;


