IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'OrderHeaderAudit')
	BEGIN
		DROP  Table OrderHeaderAudit
	END
GO

IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'OrderLines')
	BEGIN
		DROP Table OrderLines
	END
GO

IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'OrderHeader')
	BEGIN
		DROP Table OrderHeader
	END
GO


CREATE TABLE OrderHeader 
(
	OrderID			int IDENTITY (100256, 1) NOT NULL,
	ServerID		int NOT NULL,
	--OrderID			varChar(30) NOT NULL,
	UserID			varchar(50) NOT NULL,
	PriceList		int,
	DealerID		int,
	Title			varchar(10) NULL,
	cusFname		varchar(30) NULL,
	cusLname		varchar(30) NULL,
	billAddr1		varchar(30) NULL,
	billAddr2		varchar(30) NULL,
	billAddr3		varchar(30) NULL,
	billAddr4		varchar(30) NULL,
	billPcode		varchar(12) NULL,
	billPhone		varchar(15) NULL,
	billMobile		varchar(15) NULL,
	delvTitle		varchar(5)	NULL,
	delvFName		varchar(30)	NULL,
	delvLName		varchar(25)	NULL,
	delvAddr1		varchar(30) NULL,
	delvAddr2		varchar(30) NULL,
	delvAddr3		varchar(30) NULL,
	delvAddr4		varchar(30) NULL,
	delvPcode		varchar(12) NULL,
	delvPhone		varchar(15) NULL,
	RegNum			varchar(10) NULL,
	FittingDate		datetime NULL,
	isAM			bit NULL,
	Comments		varChar(500) NULL,
	AuthCode		varchar (20) NULL,
	LastUpdate		datetime NULL,
	PaymentTaken	bit NOT NULL DEFAULT 0,
	EmailSent		bit NOT NULL DEFAULT 0,
	MidasOrderID	int NOT NULL DEFAULT -1,
	ReadAttempts	int NOT NULL DEFAULT 0,
	PasRef			varChar(40) NULL,
	SiteID			int	NULL,
	CONSTRAINT PK_OrderHeader PRIMARY KEY  CLUSTERED 
	(
		OrderID
	)  ON [PRIMARY],
	CONSTRAINT [OrderHeader_FK] FOREIGN KEY 
	(
	    DealerID
	) REFERENCES Dealers (
	    DealerID
	)
)
	
GO

