if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[LastUpdate]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[LastUpdate]
GO

CREATE TABLE [dbo].[LastUpdate] (
	[ImportSection] [varchar] (20) NOT NULL ,
	[LastUpdate] [datetime] NOT NULL 
) ON [PRIMARY]
GO


INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Manufacturers', '01 Jan 1900')

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Tyres', '01 Jan 1900')

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Dealers', '01 Jan 1900')

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Prices', '01 Jan 1900')

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Quantity', '01 Jan 1900')
GO
