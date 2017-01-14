IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_InsertUpdateQuantity')
	BEGIN
		DROP  Procedure  up_InsertUpdateQuantity
	END

GO

CREATE Procedure up_InsertUpdateQuantity

	(
		@TyreID			int,
		@SiteID			int,
		@CusID			int,
		@Qty			smallint,
		@LastUpdated    DateTime = null
	)


AS
	IF EXISTS (SELECT TyreID FROM Quantity WHERE TyreID = @TyreID AND SiteID = @SiteID AND ISNULL(CusID, 0) = ISNULL(@CusID, 0))
	BEGIN
		UPDATE Quantity SET 
							Qty = @Qty,
							LastUpdated = @LastUpdated
		WHERE TyreID = @TyreID AND SiteID = @SiteID AND ISNULL(CusID, 0) = ISNULL(@CusID, 0)
	END
	ELSE
	BEGIN
		INSERT INTO Quantity	(
									TyreID,
									SiteID,
									Qty,
									CusID,
									LastUpdated
								)
		VALUES					(
									@TyreID,
									@SiteID,
									@Qty,
									CASE WHEN @CusID = 0 THEN NULL ELSE @CusID END,
									@LastUpdated
								)
	END

GO


