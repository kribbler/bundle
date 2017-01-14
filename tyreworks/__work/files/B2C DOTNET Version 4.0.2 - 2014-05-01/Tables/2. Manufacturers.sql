IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'OrderHeader')
	BEGIN
		DROP  Table OrderHeader
	END
GO

IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'OrderLines')
	BEGIN
		DROP Table OrderLines
	END
GO

IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'Prices')
	BEGIN
		DROP  Table Prices
	END
GO

IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'Tyres')
	BEGIN
		DROP  Table Tyres
	END
GO



IF EXISTS (SELECT NAME 
	   FROM   sysobjects 
	   WHERE  NAME = N'Manufacturers' 
	   AND 	  type = 'U')
    DROP TABLE Manufacturers
GO

CREATE TABLE Manufacturers
(
	ManufacturerID		int NOT NULL,
	ManufacturerName	varchar(32) NOT NULL,
	LogoImageName		varchar(30) NULL,
	SmallLogo			varchar(30) NULL,
	Title				varChar(30) NULL,
	OpeningLine			varChar(500) NULL,
	Comments			varChar(2500) NULL,
	Exclude				bit NOT NULL DEFAULT 1,
	ShowOnHome			bit NOT NULL DEFAULT 1

	CONSTRAINT [ManufacturerID_PK] PRIMARY KEY CLUSTERED 
	(
		[ManufacturerID]
	)  ON [PRIMARY]
	
)
	

GO
