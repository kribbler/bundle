DROP TABLE IF EXISTS Tyres;

CREATE TABLE  Tyres (
  TyreID int(11) NOT NULL,
  ManufacturerID int(11) default NULL,
  Width varchar(12) NOT NULL,
  Profile_Ratio varchar(12) default NULL,
  Rim_Diameter varchar(12) NOT NULL,
  LoadIndex_Speed varchar(12) default NULL,
  Load_Index varchar(12) default NULL,
  TyreDesc varchar(100) NOT NULL,
  StockCode varchar(25) NOT NULL,
  Exclude bit(1) NOT NULL default false,
  ImageName varchar(64) default NULL,
  Comments varchar(500) default NULL,
  StarRating int(11) default NULL,
  Grp varchar(2) default NULL,
  Graphic varchar(64) default NULL,
  MasterObjID int(11) default NULL,
  TreadPattern varchar(20) default NULL,
  LoadIndex varchar(8) default NULL,
  ManufacturerName 	varchar(50) NOT NULL DEFAULT '',
  ExcludePL		varchar(10) NOT NULL DEFAULT '',
  RunFlat		varchar(10) NOT NULL DEFAULT '',
  ExtraLoad		varchar(10) NOT NULL DEFAULT '',
  LocalGroup		varchar(10) NOT NULL DEFAULT '',
  
  SupplierRef 	varchar(30) NOT NULL DEFAULT '',
  TyreClass 	varchar(2) NOT NULL DEFAULT '',
  rrc_Grade	 	varchar(1) NOT NULL DEFAULT '',
  WetGrip	 	varchar(4) NOT NULL DEFAULT '',
  WetGrip_Grade varchar(1) NOT NULL DEFAULT '',
  NoiseDb	 	varchar(4) NOT NULL DEFAULT '',
  BarRating    	varchar(2) NOT NULL DEFAULT '',
  
  IsSummerTyre			bit  DEFAULT NULL,
  IsWinterTyre			bit  DEFAULT NULL,
  TyreCatalogueRef              int  DEFAULT NULL,

  LocalCategory	int DEFAULT NULL,
  BarCode 	varchar(30) DEFAULT NULL,
  ManCode varchar(2) DEFAULT NULL,

  TyreType varchar(1) DEFAULT NULL,
  OEList varchar(30) DEFAULT NULL,
  Ply varchar(4) DEFAULT NULL,
  Construction varchar(2) DEFAULT NULL,
  Season varchar(2) DEFAULT NULL,
  
  PubID int(11) DEFAULT NULL,

  Recommended varchar(1) DEFAULT NULL,
  Rating int(11) DEFAULT NULL,
  LastUpdated datetime DEFAULT NULL,
  `processed` tinyint(4) NOT NULL DEFAULT '0',


  PRIMARY KEY  (TyreID),
  KEY FK_Tyres_ManufacturerID (ManufacturerID),
  CONSTRAINT FK_Tyres_ManufacturerID FOREIGN KEY (ManufacturerID) REFERENCES Manufacturers (ManufacturerID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;