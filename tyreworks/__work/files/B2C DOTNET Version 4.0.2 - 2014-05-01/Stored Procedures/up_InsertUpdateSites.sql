IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_InsertUpdateSites')
BEGIN
	DROP  Procedure  up_InsertUpdateSites
END
GO

CREATE Procedure up_InsertUpdateSites

	(
		@SiteID INT,
		@PubID INT,
		@SiteName VARCHAR(40),
		@SiteAddress1 VARCHAR(30),
		@SiteAddress2 VARCHAR(30),
		@SiteAddress3 VARCHAR(30),
		@SiteAddress4 VARCHAR(30),
		@SitePostcode VARCHAR(8),
		@SiteTelephone1 VARCHAR(12)
	)


AS
	
	
	IF EXISTS (SELECT SiteID FROM Sites WHERE SiteID = @SiteID)
	BEGIN
		
		UPDATE Sites SET 
							
							PubID = @PubID,
							SiteName = @SiteName,
							SiteAddress1 = @SiteAddress1,
							SiteAddress2 = @SiteAddress2,
							SiteAddress3 = @SiteAddress3,
							SiteAddress4 = @SiteAddress4,
							SitePostcode = @SitePostcode,
							SiteTelephone1 = @SiteTelephone1
							
							
							
							
		WHERE				SiteID = @SiteID
	
	END
	ELSE
	BEGIN
		
		INSERT INTO Sites	(
								SiteID,
								PubID,
								SiteName,
								SiteAddress1,
								SiteAddress2,
								SiteAddress3,
								SiteAddress4,
								SitePostcode,
								SiteTelephone1

								
								
							)
		VALUES				(
								@SiteID,
								@PubID,
								@SiteName,
								@SiteAddress1,
								@SiteAddress2,
								@SiteAddress3,
								@SiteAddress4,
								@SitePostcode,
								@SiteTelephone1
							)
			
	END

	GO