ALTER TABLE Tyres ADD COLUMN SupplierRef 	varchar(30) NOT NULL DEFAULT '';
ALTER TABLE Tyres ADD COLUMN TyreClass 		varchar(2) NOT NULL DEFAULT '';
ALTER TABLE Tyres ADD COLUMN rrc_Grade	 	varchar(1) NOT NULL DEFAULT '';
ALTER TABLE Tyres ADD COLUMN WetGrip	 	varchar(4) NOT NULL DEFAULT '';
ALTER TABLE Tyres ADD COLUMN WetGrip_Grade 	varchar(1) NOT NULL DEFAULT '';
ALTER TABLE Tyres ADD COLUMN NoiseDb	 	varchar(4) NOT NULL DEFAULT '';
ALTER TABLE Tyres ADD COLUMN BarRating    	varchar(2) NOT NULL DEFAULT '';