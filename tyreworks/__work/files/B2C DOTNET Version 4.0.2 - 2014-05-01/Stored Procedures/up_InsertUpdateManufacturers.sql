IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_InsertUpdateManufacturers')
	BEGIN
		DROP  Procedure  up_InsertUpdateManufacturers
	END

GO

CREATE Procedure up_InsertUpdateManufacturers

	(
		@ManufacturerID int,
		@ManufacturerName varChar(32)
	)


AS
	
	
	IF EXISTS (SELECT ManufacturerID FROM Manufacturers WHERE ManufacturerID = @ManufacturerID)
	BEGIN
		
		UPDATE Manufacturers SET 
							ManufacturerName = @ManufacturerName
							
		WHERE				ManufacturerID = @ManufacturerID
	
	END
	ELSE
	BEGIN
		
		INSERT INTO Manufacturers	(
										ManufacturerID,
										ManufacturerName,
										Exclude							
									)
		VALUES						(
										@ManufacturerID,
										@ManufacturerName,
										0
									)
			
	END
	
	
	

GO


