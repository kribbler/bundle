IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_SelectLastUpdate')
	BEGIN
		DROP  Procedure  up_SelectLastUpdate
	END

GO

CREATE Procedure up_SelectLastUpdate
(
	@ImportSection varChar(20)	
)
AS
	
	SELECT		LastUpdate 
	FROM		LastUpdate
	
	WHERE		ImportSection = @ImportSection
	
	
GO


