IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_SelectOrderLines')
	BEGIN
		DROP  Procedure  up_SelectOrderLines
	END

GO

CREATE Procedure up_SelectOrderLines

	(
		@OrderID int
	)


AS

		SELECT		OrderLines.OrderID,
					OrderHeader.ServerID,
					Tyres.StockCode,
					Tyres.TyreDesc,
					OrderLines.Quantity,
					OrderLines.Cost,
					OrderLines.ReplyCode
					
		FROM		OrderLines
		INNER JOIN	Tyres ON OrderLines.TyreID = Tyres.TyreID
		INNER JOIN	OrderHeader ON OrderLines.OrderID = OrderHeader.OrderID
		WHERE		OrderLines.OrderID = @OrderID


GO

