if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[Prices]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[Prices]
GO

CREATE TABLE [dbo].[Prices] 
(
	[TyreID] [int] NOT NULL ,
	[PriceList] [int] NOT NULL ,
	[Cost] [real] NOT NULL ,
	DealerID int NULL,
	PubID	int NULL,
	Special int NOT NULL DEFAULT(0),
	LastUpdated   datetime    NULL
) ON [PRIMARY]
GO

ALTER TABLE [dbo].[Prices] ADD 
	CONSTRAINT [PK_Prices] PRIMARY KEY  CLUSTERED 
	(
		[TyreID],
		[PriceList]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[Prices] ADD 
	CONSTRAINT [FK_Prices_Tyres] FOREIGN KEY 
	(
		[TyreID]
	) REFERENCES [dbo].[Tyres] (
		[TyreID]
	)
GO

ALTER TABLE [dbo].[Prices] ADD 
	CONSTRAINT [FK_Prices_Dealers] FOREIGN KEY 
	(
		[DealerID]
	) REFERENCES [dbo].[Dealers] (
		[DealerID]
	)
GO

