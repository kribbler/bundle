IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_UpdateLastUpdate')
	BEGIN
		DROP  Procedure  up_UpdateLastUpdate
	END

GO

CREATE Procedure up_UpdateLastUpdate

	(
		@ImportSection varChar(20),
		@LastUpdate datetime = null
	)


AS
	
	IF @LastUpdate is null
	BEGIN
		SET @LastUpdate = GetDate()
	END
	
	UPDATE LastUpdate SET 
							LastUpdate = @LastUpdate
	
	WHERE ImportSection = @ImportSection
	
GO

