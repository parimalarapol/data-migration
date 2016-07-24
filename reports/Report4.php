<?php

putenv("ORACLE_HOME=/export/home/oracle/app/oracle/product/11.1.0/db_1");

putenv("LD_LIBRARY_PATH=/export/home/oracle/app/oracle/product/11.1.0/db_1/lib");


$connection = ocilogon("vrami2","oracle", "oracle.uis.edu");

if (!$connection) {

echo "Couldnt make a connection!";

exit;

}
//$year = $_POST["year"];

$sqlquery = " SELECT album_name,performance_date
FROM album a ,
  performance p
WHERE a.band_id =p.band_id
AND revenue  IN(
(SELECT REVENUE FROM
    (SELECT revenue,
      DENSE_RANK() OVER (ORDER BY revenue DESC) albm_dense_rank
    FROM performance
    )
WHERE albm_dense_rank <= 1))order by p.REVENUE desc " ;

$sql_id = ociparse($connection, $sqlquery);

if (!$sql_id) {

$e= oci_error ($connection);

print htmlentities($e['message']);

exit;

}

ociexecute($sql_id , OCI_DEFAULT);

  
  //print "<p style=\"font-size:30px; color: blue\"> <b> Report details for best selling album for the given year. </p></b></div>\n"; 
  print "<b><div align=\"center\"><font color=\"blue\"><font size=\"6\">Report details for which album has the highest revenue till date.</font></b></div><br>\n";

    print "<table border=\"2\" style= \"background-color: #b0c4de; color: black; margin: 0 auto;\" >\n";

   print "  <TR><TH>ALBUM NAME</TH><TH>PERFORMANCE DATE</TH></TR>\n";

while(OCIFetch($sql_id)) 

   { 

      print "  <TR>\n"; 

      print "    <TD>" . OCIResult($sql_id, "ALBUM_NAME") . "</TD>\n"; 
	  
	  print "    <TD>" . OCIResult($sql_id, "PERFORMANCE_DATE") . "</TD>\n";  

print "  </TR>\n"; 

   }
   print "\n";

ocilogoff($connection);

?>

</body>

</html>

