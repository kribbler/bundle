IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_Import_FinalUpdateDealers')
	BEGIN
		DROP  Procedure  up_Import_FinalUpdateDealers
	END

GO

CREATE Procedure up_Import_FinalUpdateDealers

AS
	
	--UPDATE Dealers
		--SET Easting = P.Easting, Northing = P.Northing
		--FROM PostcodeLite.dbo.Postcodes P
		--WHERE Dealers.Postcode_Trim = P.Postcode_trim --collate Latin1_General_CI_AI
	
	UPDATE LastUpdate SET LastUpdate = GetDate() WHERE ImportSection = 'Dealers'
	

GO


