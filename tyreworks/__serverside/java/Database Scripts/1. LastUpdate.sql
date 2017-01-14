drop table IF EXISTS LastUpdate;


CREATE TABLE LastUpdate 
(
	ImportSection   varchar(20)     NOT NULL PRIMARY KEY,
	LastUpdate      datetime        NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Manufacturers', '1900-01-01');

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Tyres', '1900-01-01');

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Dealers', '1900-01-01');

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Prices', '1900-01-01');

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Quantity', '1900-01-01');

INSERT INTO LastUpdate (ImportSection, LastUpdate)
VALUES ('Sites', '1900-01-01');



