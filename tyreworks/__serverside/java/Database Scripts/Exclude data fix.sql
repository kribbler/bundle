ALTER TABLE Tyres CHANGE Exclude Exclude int;
update tyres set exclude = 2 where exclude = 1;
update tyres set exclude = 1 where exclude = 0;
update tyres set exclude = 0 where exclude = 2;
ALTER TABLE Tyres CHANGE Exclude Exclude bit(1);


ALTER TABLE Dealers CHANGE Exclude Exclude int;
update Dealers set exclude = 2 where exclude = 1;
update Dealers set exclude = 1 where exclude = 0;
update Dealers set exclude = 0 where exclude = 2;
ALTER TABLE Dealers CHANGE Exclude Exclude bit(1);