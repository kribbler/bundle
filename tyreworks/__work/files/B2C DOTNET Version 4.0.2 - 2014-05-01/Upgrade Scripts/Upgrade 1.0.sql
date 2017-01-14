IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Tyres' AND COLUMN_NAME = 'TreadPattern')
BEGIN
	alter table tyres add TreadPattern		varchar(10) NULL,
	LoadIndex			varchar(8)	NULL
END
GO

update lastupdate set lastupdate = '01 Jan 2009'
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
		@LoadIndex			varchar(8) = null
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
							LoadIndex = @LoadIndex
							
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
								LoadIndex
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
								@LoadIndex
							)			
	END


	

GO


