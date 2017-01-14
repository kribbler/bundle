IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'Quantity')
	BEGIN
		DROP  Table Quantity
	END
GO

CREATE TABLE Quantity
(
   TyreID		int NOT NULL,
   SiteID		int NOT NULL,
   CusID		int NULL,
   Qty			smallint NULL,
   LastUpdated  datetime    NULL

) ON [PRIMARY]
GO

ALTER TABLE Quantity ADD 
	CONSTRAINT [PK_Quantity] PRIMARY KEY  CLUSTERED 
	(
		TyreID,
		SiteID
		
	)  ON [PRIMARY] 
GO

