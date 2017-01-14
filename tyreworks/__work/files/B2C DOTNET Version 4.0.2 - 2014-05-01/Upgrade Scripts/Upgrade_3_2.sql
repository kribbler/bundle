IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Tyres' AND COLUMN_NAME = 'SupplierRef')
BEGIN
	ALTER TABLE Tyres ADD 
		SupplierRef			varchar(30) NOT NULL DEFAULT(''),
		TyreClass			varchar(2)	NOT NULL DEFAULT(''),
		rrc_Grade			varchar(1)	NOT NULL DEFAULT(''),
		WetGrip				varchar(4)	NOT NULL DEFAULT(''),
		WetGrip_Grade		varchar(1)  NOT NULL DEFAULT(''),		
		NoiseDb				varchar(4)  NOT NULL DEFAULT(''),
		BarRating			varchar(2)  NOT NULL DEFAULT('')	
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
		@Width				varChar(12),
		@Profile_Ratio		varChar(12),
		@Rim_Diameter		varChar(12),
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
		@LocalGroup			varchar(10) = '',
		
		@SupplierRef        varchar(30) = '',
		@TyreClass          varchar(2)  = '',
		@rrc_Grade          varchar(1)	= '',
		@WetGrip            varchar(4)  = '',
		@WetGrip_Grade		varchar(1)  = '',		
		@NoiseDb            varchar(4)  = '',
		@BarRating			varchar(2)  = ''
		
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
							LocalGroup = @LocalGroup,
							
							SupplierRef = @SupplierRef,
							TyreClass = @TyreClass,
							rrc_Grade = @rrc_Grade,
							WetGrip = @WetGrip,
							WetGrip_Grade = @WetGrip_Grade,
							NoiseDb = @NoiseDb,
							BarRating = @Barrating
							
							
							
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
								LocalGroup,
								
								SupplierRef,
								TyreClass,
								rrc_Grade,
								WetGrip,
								WetGrip_Grade,
								NoiseDb,
								BarRating
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
								@LocalGroup,
								@SupplierRef,
								@TyreClass,
								@rrc_Grade,
								@WetGrip,
								@WetGrip_Grade,
								@NoiseDb,
								@BarRating
							)			
	END


