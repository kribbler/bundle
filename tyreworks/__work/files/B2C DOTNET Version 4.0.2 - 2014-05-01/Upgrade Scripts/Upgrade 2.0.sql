IF EXISTS (SELECT * FROM sysobjects WHERE type = 'U' AND name = 'DealerSite')
	BEGIN
		DROP  Table DealerSite
	END
GO

CREATE TABLE DealerSite
(
	DealerID			int NOT NULL,
	SiteID				int NOT NULL,
	
	CONSTRAINT PK_DealerSite PRIMARY KEY (DealerID, SiteID),
	CONSTRAINT FK_DealerSite_DealerID FOREIGN KEY (DealerID) REFERENCES Dealers(DealerID)
)
GO



IF EXISTS (SELECT * FROM sysobjects WHERE type = 'P' AND name = 'up_InsertUpdateDealers')
	BEGIN
		DROP  Procedure  up_InsertUpdateDealers
	END

GO

CREATE Procedure up_InsertUpdateDealers

	(
		@CusID			int,
		@SiteID			int,
		@CusCode		varChar(20),
		@DealerName		varChar(50),
		@Address1		varChar(50),
		@Address2		varChar(50),
		@Address3		varChar(50),
		@CityCounty		varChar(50),
		@Postcode		varChar(10),
		@Postcode_Trim	varChar(10),
		@PhoneNumber	varChar(30),
		@FaxNumber		varChar(15),
		@Exclude bit
	)


AS
	
	IF EXISTS (SELECT DealerName FROM Dealers WHERE DealerID = @CusID)
	BEGIN
		
		UPDATE Dealers SET 
							SiteID = @SiteID,
							CusCode = @CusCode,
							DealerName = @DealerName,
							Address1 = @Address1,
							Address2 = @Address2,
							Address3 = @Address3,
							CityCounty = @CityCounty,
							Postcode = @Postcode,
							Postcode_Trim = @Postcode_Trim,
							PhoneNumber = @PhoneNumber,
							FaxNumber = @FaxNumber,
							Exclude = @Exclude
							
		WHERE				DealerID = @CusID
	
	END
	ELSE
	BEGIN
		
		INSERT INTO Dealers	(
								DealerID,
								SiteID,
								CusCode,
								DealerName,
								Address1,
								Address2,
								Address3,
								CityCounty,
								Postcode,
								Postcode_Trim,
								PhoneNumber,
								FaxNumber,
								Exclude
								
							)
		VALUES				(
								@CusID,
								@SiteID,
								@CusCode,
								@DealerName,
								@Address1,
								@Address2,
								@Address3,
								@CityCounty,
								@Postcode,
								@Postcode_Trim,
								@PhoneNumber,
								@FaxNumber,
								@Exclude
							)
			
	END
	
	IF NOT EXISTS(SELECT 1 FROM DealerSite WHERE DealerID = @CusID AND SiteID = @SiteID)
	BEGIN
		INSERT INTO DealerSite (
									DealerID,
									SiteID
								)
		VALUES					(
									@CusID,
									@SiteID
								)
	END
	

GO


UPDATE LastUpdate SET LastUpdate = '01 Jan 1900'
WHERE ImportSection = 'Dealers'
GO