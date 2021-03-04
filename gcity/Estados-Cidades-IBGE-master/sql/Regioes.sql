-- Create Table --

CREATE TABLE Regioes (
  id_regiao 	INT PRIMARY KEY	NOT NULL AUTO_INCREMENT,
  Nome 	VARCHAR(50) NOT NULL
);

-- Insert Data --

Insert into Regioes (id_regiao, Nome) values (1, 'Norte');
Insert into Regioes (id_regiao, Nome) values (2, 'Nordeste');
Insert into Regioes (id_regiao, Nome) values (3, 'Sudeste');
Insert into Regioes (id_regiao, Nome) values (4, 'Sul');
Insert into Regioes (id_regiao, Nome) values (5, 'Centro-Oeste');
