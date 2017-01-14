IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'Sites')
	BEGIN
		DROP TABLE Sites
	END
GO

CREATE TABLE Sites
(
	SiteID INT NOT NULL ,
	PubID INT NOT NULL ,
	SiteName VARCHAR(40) NOT NULL ,
	SiteAddress1 VARCHAR(30) NOT NULL DEFAULT '' ,
	SiteAddress2 VARCHAR(30) NOT NULL DEFAULT '' ,
	SiteAddress3 VARCHAR(30) NOT NULL DEFAULT '' ,
	SiteAddress4 VARCHAR(30) NOT NULL DEFAULT '' ,
	SitePostcode VARCHAR(8) NOT NULL DEFAULT '' ,
	SiteTelephone1 VARCHAR(12) NOT NULL DEFAULT '' ,
	
	CONSTRAINT PK_Sites PRIMARY KEY (SiteID)
	
)
GO