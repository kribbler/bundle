 IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Prices' AND COLUMN_NAME = 'Special')
 BEGIN
	ALTER TABLE Prices ADD
	Special int NOT NULL DEFAULT(0)
 END
 GO
 
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
		@Special	int = 0
	)


AS

	IF EXISTS (SELECT TyreID FROM Prices WHERE TyreID = @TyreID AND PriceList = @PrList)
	BEGIN
		UPDATE Prices SET 
							PriceList = @PrList,
							Cost = @Cost,
							Special = @Special
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
									Special
								)
			VALUES				(
									@TyreID,
									@PrList,
									@Cost,
									@DealerID,
									@PubID,
									@Special
								)
		END
	END


GO


