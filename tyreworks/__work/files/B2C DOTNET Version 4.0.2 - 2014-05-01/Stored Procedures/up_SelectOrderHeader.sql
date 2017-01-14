IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_SelectOrderHeader')
	BEGIN
		DROP  Procedure  up_SelectOrderHeader
	END

GO

CREATE Procedure up_SelectOrderHeader

	(
		@OrderID int
	)


AS
		
		SELECT		OrderID,
					ServerID,
					UserID,
					PriceList,
					DealerID,
					Title,
					cusFName,
					cusLName,
					billAddr1,
					billAddr2,
					billAddr3,
					billAddr4,
					billPCode,
					billPhone,
					billMobile,
					delvTitle,
					delvFName,
					delvLName,
					delvAddr1,
					delvAddr2,
					delvAddr3,
					delvAddr4,
					delvPcode,
					delvPhone,
					RegNum,
					FittingDate,
					IsAm,
					Comments,
					AuthCode,
					LastUpdate,
					PaymentTaken,
					EmailSent,
					MidasOrderID,
					PasRef,
					SiteID
		
		FROM		OrderHeader
		
		WHERE		OrderID = @OrderID

GO


