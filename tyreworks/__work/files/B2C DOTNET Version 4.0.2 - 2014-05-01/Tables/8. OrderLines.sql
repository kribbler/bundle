IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'OrderLines')
	BEGIN
		DROP Table OrderLines
	END
GO

CREATE TABLE OrderLines 
(
	OrderID			int NOT NULL,
	TyreID			int NOT NULL,
	Quantity		int NULL DEFAULT 1,
	Cost			real NOT NULL,
	CostWithVAT		real NOT NULL,
	ReplyCode		int NOT NULL DEFAULT 255, -- NO REPLY YET

	CONSTRAINT PK_OrderLines PRIMARY KEY  CLUSTERED 
	(
		OrderID,
		TyreID
	)  ON [PRIMARY],
	CONSTRAINT [OrderID_FK] FOREIGN KEY 
	(
	    OrderID
	) REFERENCES OrderHeader (
	    OrderID
	),
	CONSTRAINT [OrdersTyres_FK] FOREIGN KEY 
	(
	    TyreID
	) REFERENCES Tyres (
	    TyreID
	)
	
	
)
	
GO

