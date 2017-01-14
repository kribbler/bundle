IF EXISTS (SELECT NAME 
	   FROM   sysobjects 
	   WHERE  NAME = N'Tyres' 
	   AND 	  type = 'U')
    DROP TABLE Tyres
GO

CREATE TABLE Tyres
(
	TyreID				int	NOT NULL,
	ManufacturerID		int NULL,
	Width				varchar(12)	NOT NULL,
	Profile_Ratio		varchar(12)	NULL,
	Rim_Diameter		varchar(12)	NOT NULL,
	LoadIndex_Speed		varchar(12)		NULL,
	Load_Index			varchar(12)		NULL,
	TyreDesc			Varchar(100)	NOT NULL,
	StockCode			VarChar(25) NOT NULL,
	Exclude				bit NOT NULL DEFAULT 1,
	ImageName			varChar(64) NULL,
	Comments			varChar(500) NULL,
	StarRating			int NULL,
	Grp					varchar(2) NULL,
	Graphic				varchar(64) NULL,
	MasterObjID			int NULL,
	
	TreadPattern		varchar(20) NULL,
	LoadIndex			varchar(8)	NULL,
	
	ManufacturerName	varchar(50) NOT NULL DEFAULT(''),
	ExcludePL			varchar(10) NOT NULL DEFAULT(''),
	RunFlat				varchar(10) NOT NULL DEFAULT(''),
	ExtraLoad			varchar(10) NOT NULL DEFAULT(''),
	LocalGroup			varchar(10) NOT NULL DEFAULT(''),
	
	SupplierRef			varchar(30) NOT NULL DEFAULT(''),
	TyreClass			varchar(2)	NOT NULL DEFAULT(''),
	rrc_Grade			varchar(1)	NOT NULL DEFAULT(''),
	WetGrip				varchar(4)	NOT NULL DEFAULT(''),
	WetGrip_Grade		varchar(1)  NOT NULL DEFAULT(''),		
	NoiseDb				varchar(4)  NOT NULL DEFAULT(''),
	BarRating			varchar(2)  NOT NULL DEFAULT(''),

    IsSummerTyre        bit		    NULL, 
    IsWinterTyre        bit		    NULL,
    TyreCatalogueRef    int	        NULL,

	LocalCategory		int			NULL,
    BarCode             varchar(30) NULL,
    ManCode             varchar(2)  NULL,

    OEList				varchar(30) NULL,
    Ply					varchar(4)	NULL,
    Construction		varchar(2)	NULL,
	Season				varchar(2)	NULL,
	TyreType			varchar(1)  NULL,
	Recommended			varchar(1)  NULL,
    Rating              int			NULL,
    LastUpdated         datetime    NULL

					

    
	
	CONSTRAINT [TyreID_PK] PRIMARY KEY  CLUSTERED 
	(
		[TyreID]
	)  ON [PRIMARY] ,
	CONSTRAINT [Manufacturer1_FK] FOREIGN KEY 
	(
	    [ManufacturerID]
	) REFERENCES [Manufacturers] (
	    [ManufacturerID]
	)
)
GO