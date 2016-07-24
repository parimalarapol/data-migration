<?php

putenv("ORACLE_HOME=/export/home/oracle/app/oracle/product/11.1.0/db_1");

putenv("LD_LIBRARY_PATH=/export/home/oracle/app/oracle/product/11.1.0/db_1/lib");


$connection = ocilogon("vrami2","oracle", "oracle.uis.edu");

if (!$connection) {

echo "Couldnt make a connection!";

exit;

}

//$year = $_POST["year"];

$inputBName = $_POST["inputBName"];

$sqlquery = " SELECT album_name,
  venue_name,
  live_count,
  performance_date,
  revenue
FROM album a ,
  bands b ,
  performance p
WHERE a.band_id=b.band_id
AND b.band_id  =p.band_id
AND b.band_name='$inputBName' " ;

$sql_id = ociparse($connection, $sqlquery);

if (!$sql_id) {

$e= oci_error ($connection);

print htmlentities($e['message']);

exit;

}

ociexecute($sql_id , OCI_DEFAULT);

  
  //print "<p style=\"font-size:30px; color: blue\"> <b> Report details for best selling album for the given year. </p></b></div>\n"; 
  print "<b><div align=\"center\"><font color=\"blue\"><font size=\"6\">Details of the given Band Name.</font></b></div><br>\n";

    print "<table border=\"2\" style= \"background-color: #b0c4de; color: black; margin: 0 auto;\" >\n";

   print "  <TR><TH>ALBUM NAME</TH><TH>VENUE NAME</TH><TH>LIVE COUNT</TH><TH>PERFORMANCE DATE</TH><TH>REVENUE</TH></TR>\n";

while(OCIFetch($sql_id)) 

   { 

      print "  <TR>\n"; 

      print "    <TD>" . OCIResult($sql_id, "ALBUM_NAME") . "</TD>\n"; 

      print "    <TD>" . OCIResult($sql_id, "VENUE_NAME") . "</TD>\n"; 
	  
      print "    <TD>" . OCIResult($sql_id, "LIVE_COUNT") . "</TD>\n";
	  
      print "    <TD>" . OCIResult($sql_id, "PERFORMANCE_DATE") . "</TD>\n";
 
      print "    <TD>" . OCIResult($sql_id, "REVENUE") . "</TD>\n"; 
	  

print "  </TR>\n"; 

   }
   print "\n";

ocilogoff($connection);

?>

</body>

</html>

