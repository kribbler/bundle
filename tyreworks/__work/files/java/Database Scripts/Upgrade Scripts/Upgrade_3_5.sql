ALTER TABLE Tyres ADD COLUMN Pubid int DEFAULT NULL;

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Sites', '1900-01-01');


DROP TABLE  IF EXISTS Sites;


CREATE  TABLE Sites 

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
  
PRIMARY KEY (SiteID)
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  

    