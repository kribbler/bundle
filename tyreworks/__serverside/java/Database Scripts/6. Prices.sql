drop table IF EXISTS Prices;

CREATE TABLE Prices 
(
	TyreID          int         NOT NULL,
	PriceList       int         NOT NULL ,
	Cost            real        NOT NULL ,
	DealerID        int         NULL,
	PubID           int         NULL,
	UpdatedDate     datetime    NULL, 
	Special         int         NOT NULL DEFAULT 0,
    LastUpdated datetime        NULL,
        
        PRIMARY KEY (TyreID, PriceList),

        KEY FK_Prices_DealerID (DealerID),

        CONSTRAINT FK_Prices_DealerID FOREIGN KEY (DealerID) REFERENCES Dealers (DealerID),

        CONSTRAINT FK_Prices_TyreID FOREIGN KEY (TyreID) REFERENCES Tyres (TyreID)
        
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

