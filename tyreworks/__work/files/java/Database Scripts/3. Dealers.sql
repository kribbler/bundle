DROP TABLE  IF EXISTS Dealers;

CREATE TABLE Dealers
(
	DealerID			int NOT NULL,
	SiteID				int NOT NULL,
	CusCode				varchar(20) NOT NULL,
	DealerName			varchar(50) NOT NULL,
	Address1			varchar(50) NOT NULL DEFAULT '',
	Address2			varchar(50) NOT NULL DEFAULT '',
	Address3			varchar(50) NOT NULL DEFAULT '',
	CityCounty			varchar(50) NOT NULL DEFAULT '',
	Postcode			varchar(10) NOT NULL DEFAULT '',
	Postcode_Trim		varchar(10) NOT NULL DEFAULT '',
	PhoneNumber			varchar(30) NOT NULL DEFAULT '',
	FaxNumber			varchar(15) NOT NULL DEFAULT '',
	EmailAddress		varchar(100) NOT NULL DEFAULT '',
	WebAddress			varchar(100) NOT NULL DEFAULT '',
	Easting				int NOT NULL DEFAULT 0,
	Northing			int NOT NULL DEFAULT 0,
	Exclude				bit NOT NULL DEFAULT 1,
	GetPrices			bit NOT NULL DEFAULT 0,
        
        PRIMARY KEY (DealerID, SiteID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;