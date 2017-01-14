IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Tyres' AND COLUMN_NAME = 'ManufacturerName')
BEGIN
	ALTER TABLE Tyres ADD 
		ManufacturerName	varchar(50) NOT NULL DEFAULT(''),
		ExcludePL			varchar(10) NOT NULL DEFAULT(''),
		RunFlat				varchar(10) NOT NULL DEFAULT(''),
		ExtraLoad			varchar(10) NOT NULL DEFAULT(''),
		LocalGroup			varchar(10) NOT NULL DEFAULT('')

END
GO

IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_InsertUpdateTyres')
	BEGIN
		DROP  Procedure  up_InsertUpdateTyres
	END

GO

CREATE Procedure up_InsertUpdateTyres

	(
		@TyreID				int,
		@ManufacturerID		int,
		@StockCode			varChar(25),
		@Width				varChar(5),
		@Profile_Ratio		varChar(5),
		@Rim_Diameter		varChar(5),
		@LoadIndex_Speed	varChar(12),
		@Load_Index			varChar(12),
		@TyreDesc			varChar(100),
		@Exclude			bit,
		@StarRating			int,
		@Grp				varchar(2),
		@Graphic			varchar(64) = '',
		@MasterObjID		int = null,
		@TreadPattern		varchar(10) = null,
		@LoadIndex			varchar(8) = null,
		
		@ManufacturerName	varchar(50) = '',
		@ExcludePL			varchar(10) = '',
		@RunFlat			varchar(10) = '',
		@ExtraLoad			varchar(10) = '',
		@LocalGroup			varchar(10) = ''
	)


AS

	
	IF EXISTS (SELECT TyreID FROM Tyres WHERE TyreID = @TyreID)
	BEGIN
		
		UPDATE Tyres SET 
							StockCode = @StockCode,
							Width = @Width,
							Profile_Ratio = @Profile_Ratio,
							Rim_Diameter = @Rim_Diameter,
							LoadIndex_Speed = @LoadIndex_Speed,
							TyreDesc = @TyreDesc,
							Exclude = @Exclude,
							ManufacturerID = @ManufacturerID,
							StarRating = @StarRating,
							Grp = @Grp,
							Graphic = @Graphic,
							MasterObjID = @MasterObjID,
							TreadPattern = @TreadPattern,
							LoadIndex = @LoadIndex,
							
							ManufacturerName = @ManufacturerName,
							ExcludePL = @ExcludePL,
							RunFlat = @RunFlat,
							ExtraLoad = @ExtraLoad,
							LocalGroup = @LocalGroup
							
		WHERE				TyreID = @TyreID --and PriceList = @PriceList				
	END
	ELSE
	BEGIN
		
		INSERT INTO Tyres	(
								TyreID,
								StockCode,
								Width,
								Profile_Ratio,
								Rim_Diameter,
								LoadIndex_Speed,
								TyreDesc,
								Exclude,
								ManufacturerID,
								StarRating,
								Grp,
								Graphic,
								MasterObjID,
								TreadPattern,
								LoadIndex,
								ManufacturerName,
								ExcludePL,
								RunFlat,
								ExtraLoad,
								LocalGroup
							)
		VALUES				(
								@TyreID,
								@StockCode,
								@Width,
								@Profile_Ratio,
								@Rim_Diameter,
								@LoadIndex_Speed,
								@TyreDesc,
								@Exclude,
								@ManufacturerID,
								@StarRating,
								@Grp,
								@Graphic,
								@MasterObjID,
								@TreadPattern,
								@LoadIndex,
								@ManufacturerName,
								@ExcludePL,
								@RunFlat,
								@ExtraLoad,
								@LocalGroup
							)			
	END
GO


