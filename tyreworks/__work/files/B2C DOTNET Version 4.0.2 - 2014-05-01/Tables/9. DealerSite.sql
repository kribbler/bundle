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