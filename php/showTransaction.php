<?php

putenv("ORACLE_HOME=/export/home/oracle/app/oracle/product/11.1.0/db_1");

putenv("LD_LIBRARY_PATH=/export/home/oracle/app/oracle/product/11.1.0/db_1/lib");

//Connecting to Oracle Database

$connection = ocilogon("vrami2","oracle", "oracle.uis.edu");

if (!$connection) {

echo "Couldnt make a connection!";

exit;

}

//Sql query to select columns

$sqlquery = " SELECT lastname,
  firstname,
  street,
  state,
  city,
  zippostalcode,
  country,
  areacode,
  phonenumber,
  email,
  salesprice,
  askingprice,
  datesold FROM CUSTOMER C,TRANS T
WHERE c.CUSTOMERID =
  (SELECT MAX(CUSTOMERID) FROM CUSTOMER
  )
AND c.customerid=t.CUSTOMERID " ;

$sql_id = ociparse($connection, $sqlquery);

if (!$sql_id) {

$e= oci_error ($connection);

print htmlentities($e['message']);

exit;

}

ociexecute($sql_id , OCI_DEFAULT);


    print "<marquee> <p style=\"font-size:30px; color: red\"> <b> Customer Transaction Report </p></b> </marquee> \n"; 

    print "<table border=\"2\" style= \"background-color: #b0c4de; color: black; margin: 0 auto;\" >\n";

    print "  <TR><TH>Last Name</TH><TH>First Name</TH><TH>Street</TH><TH>State</TH><TH>City</TH><TH>ZipCode</TH><TH>AreaCode</TH><TH>Phone</TH><TH>Email</TH><TH>SalesPrice</TH><TH>AskingPrice</TH><TH>DateSold</TH></TR>\n";

while(OCIFetch($sql_id)) 

   { 

        print "  <TR>\n"; 

        print "    <TD>" . OCIResult($sql_id, "LASTNAME") . "</TD>\n"; 

        print "    <TD>" . OCIResult($sql_id, "FIRSTNAME") . "</TD>\n"; 

	    print "    <TD>" . OCIResult($sql_id, "STREET") . "</TD>\n"; 

	    print "    <TD>" . OCIResult($sql_id, "STATE") . "</TD>\n";  
		
		print "    <TD>" . OCIResult($sql_id, "CITY") . "</TD>\n";  
		
		print "    <TD>" . OCIResult($sql_id, "ZIPPOSTALCODE") . "</TD>\n";  
		
		print "    <TD>" . OCIResult($sql_id, "AREACODE") . "</TD>\n";  
		
		print "    <TD>" . OCIResult($sql_id, "PHONENUMBER") . "</TD>\n";  
		
		print "    <TD>" . OCIResult($sql_id, "EMAIL") . "</TD>\n"; 
		
		print "    <TD>" . OCIResult($sql_id, "SALESPRICE") . "</TD>\n"; 
		
		print "    <TD>" . OCIResult($sql_id, "ASKINGPRICE") . "</TD>\n"; 
		
		print "    <TD>" . OCIResult($sql_id, "DATESOLD") . "</TD>\n";  

        print "  </TR>\n"; 

   }
        print "\n";

ocilogoff($connection);

?>

</body>

</html>

