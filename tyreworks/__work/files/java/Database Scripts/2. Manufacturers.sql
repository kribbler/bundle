DROP  Table IF EXISTS OrderLines;
DROP  Table IF EXISTS OrderHeader;
DROP  Table  IF EXISTS Prices;
DROP  Table  IF EXISTS Tyres;
DROP TABLE  IF EXISTS Manufacturers;

CREATE TABLE Manufacturers
(
	ManufacturerID		int             NOT NULL    PRIMARY KEY,
	ManufacturerName	varchar(32)     NOT NULL,
	LogoImageName		varchar(30)     NULL,
	SmallLogo		varchar(30)     NULL,
	Title			varChar(30)     NULL,
	OpeningLine		varChar(500)    NULL,
	Comments		varChar(2500)   NULL,
	Exclude			bit             NOT NULL DEFAULT 1,
	ShowOnHome              bit             NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
