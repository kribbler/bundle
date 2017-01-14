IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_SelectSiteList')
	BEGIN
		DROP  Procedure  up_SelectSiteList
	END

GO

CREATE Procedure up_SelectSiteList

AS
	
	SELECT DISTINCT SiteID
	FROM DealerSite

GO


