ALTER TABLE Tyres 
	Alter Column TreadPattern varchar(20)
		
		

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
		
		@TreadPattern		varchar(20) = null,
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
		@BarRating			varchar(2)  = '',

		@IsSummerTyre       bit = 0,
        @IsWinterTyre       bit = 0,
        @TyreCatalogueRef   int = 0,
		
		@LocalCategory		int = 0,			
        @BarCode            varchar(30) = '',   
		@ManCode            varchar(2)  = '',
		

		@OEList				varchar(30) = '',
		@Ply				varchar(4)	= '',
		@Construction		varchar(2)	= '',
		@Season				varchar(2)  = '',
		@TyreType			varchar(1)  = '',
		
		@Recommended		char(1) =  '',
        @Rating             int = null,
        @LastUpdated        datetime = null

		
		
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
							BarRating = @Barrating,
							IsSummerTyre = @IsSummerTyre,
                            IsWinterTyre = @IsWinterTyre,
                            TyreCatalogueRef = @TyreCatalogueRef,
							
							LocalCategory = @LocalCategory,
							BarCode = @BarCode,
							ManCode = @ManCode,
							
							OEList = @OEList,
							Ply = @Ply,
							Construction = @Construction,
							Season = @Season,
							TyreType = @TyreType,
							
							Recommended = @Recommended,
							Rating = @Rating,            
							LastUpdated = @LastUpdated
							     
							
							
							
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
								Barrating,
								IsSummerTyre,
							    IsWinterTyre,
								TyreCatalogueRef,
								
								LocalCategory,
								BarCode,
								ManCode,

								OEList,
								Ply,
								Construction,
								Season,
								TyreType,
								
								Recommended,
								Rating,            
								LastUpdated
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
								@Barrating,
							    @IsSummerTyre,
                                @IsWinterTyre,
								@TyreCatalogueRef,

								@LocalCategory,
								@BarCode,
								@ManCode,

								@OEList,
								@Ply,
								@Construction,
								@Season,
								@TyreType,
								
								@Recommended,
								@Rating,            
								@LastUpdated
							)			
	END


	

GO