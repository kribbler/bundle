ALTER TABLE Tyres
ADD COLUMN Recommended varchar(1) DEFAULT NULL,
ADD COLUMN Rating int(11) DEFAULT NULL,
ADD COLUMN LastUpdated datetime DEFAULT NULL;

ALTER TABLE Prices
ADD COLUMN LastUpdated datetime DEFAULT NULL;

ALTER TABLE Quantity
ADD COLUMN LastUpdated datetime DEFAULT NULL;
