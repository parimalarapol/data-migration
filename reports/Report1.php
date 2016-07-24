<?php

putenv("ORACLE_HOME=/export/home/oracle/app/oracle/product/11.1.0/db_1");

putenv("LD_LIBRARY_PATH=/export/home/oracle/app/oracle/product/11.1.0/db_1/lib");


$connection = ocilogon("vrami2","oracle", "oracle.uis.edu");

if (!$connection) {

echo "Couldnt make a connection!";

exit;

}
//$year = $_POST["year"];

$sqlquery = " SELECT ALBUM_NAME ,f.revenue FROM ALBUM a,ALBUM_FACTS_TABLE f where a.album_id = f.album_id and revenue=(select max(revenue) from album_facts_table ) " ;

$sql_id = ociparse($connection, $sqlquery);

if (!$sql_id) {

$e= oci_error ($connection);

print htmlentities($e['message']);

exit;

}

ociexecute($sql_id , OCI_DEFAULT);

  
  //print "<p style=\"font-size:30px; color: blue\"> <b> Report details for best selling album for the given year. </p></b></div>\n"; 
  print "<b><div align=\"center\"><font color=\"blue\"><font size=\"6\">Report details for best selling album.</font></b></div><br>\n";

    print "<table border=\"2\" style= \"background-color: #b0c4de; color: black; margin: 0 auto;\" >\n";

   print "  <TR><TH>ALBUM NAME</TH><TH>REVENUE</TH></TR>\n";

while(OCIFetch($sql_id)) 

   { 

      print "  <TR>\n"; 

      print "    <TD>" . OCIResult($sql_id, "ALBUM_NAME") . "</TD>\n"; 

      print "    <TD>" . OCIResult($sql_id, "REVENUE") . "</TD>\n";       

print "  </TR>\n"; 

   }
   print "\n";

ocilogoff($connection);

?>

</body>

</html>

