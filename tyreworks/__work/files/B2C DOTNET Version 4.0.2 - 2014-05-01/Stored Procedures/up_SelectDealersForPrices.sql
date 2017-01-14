IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_SelectDealersForPrices')
	BEGIN
		DROP  Procedure  up_SelectDealersForPrices
	END

GO

CREATE Procedure up_SelectDealersForPrices

AS
	
	SELECT DealerID FROM Dealers WHERE GetPrices = 1

GO



