IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_InsertUpdatePrices')
	BEGIN
		DROP  Procedure  up_InsertUpdatePrices
	END

GO

CREATE Procedure up_InsertUpdatePrices

	(
		@TyreID		int,
		@PrList		int,
		@Cost		real,
		@DealerID	int,
		@PubID		int = null,
		@Special	int = 0,
		@LastUpdated DateTime = null
	)


AS

	IF EXISTS (SELECT TyreID FROM Prices WHERE TyreID = @TyreID AND PriceList = @PrList)
	BEGIN
		UPDATE Prices SET 
							PriceList = @PrList,
							Cost = @Cost,
							Special = @Special,
							LastUpdated = @LastUpdated
		WHERE TyreID = @TyreID AND PriceList = @PrList
	END
	ELSE
	BEGIN
		IF EXISTS(SELECT TyreID FROM Tyres WHERE TyreID = @TyreID)
		BEGIN
			INSERT INTO Prices	(
									TyreID,
									PriceList,
									Cost,
									DealerID,
									PubID,
									Special,							
									LastUpdated
								)
			VALUES				(
									@TyreID,
									@PrList,
									@Cost,
									@DealerID,
									@PubID,
									@Special,
									@LastUpdated
								)
		END
	END


GO


