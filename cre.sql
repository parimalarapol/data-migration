CREATE TABLE CUSTOMERS (
      CustomerID 	Int 		  NOT NULL,
      LastName 		Char(25) 	  NOT NULL,
      FirstName 	Char(25) 	  NOT NULL,
      Street 		Char(30) 	  NULL,
      City 		Char(35) 	  NULL,
      State 		Char(2) 	  NULL,
      ZipPostalCode	Char(9)		  NULL, 
      Country		Char(50)	  NULL,
      AreaCode 		Char(3)		  NULL,
      PhoneNumber 	Char(8) 	  NULL,
      Email		Varchar(100) 	  NUll,
      CONSTRAINT 	CustomerPK	  PRIMARY KEY(CustomerID),
      CONSTRAINT 	EmailAK1	  UNIQUE(Email)
      );