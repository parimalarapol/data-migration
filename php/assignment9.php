<?php

putenv("ORACLE_HOME=/export/home/oracle/app/oracle/product/11.1.0/db_1");

putenv("LD_LIBRARY_PATH=/export/home/oracle/app/oracle/product/11.1.0/db_1/lib");


?>
<style>
    body{
        background-image: url("titanicc.jpg");

    }
    h2{
        background-color: red;
      }
</style>
<style type="text/css">
img.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>

<img src="Titanic.jpeg" class="center" />

<?php

$connection = ocilogon("vrami2","oracle", "oracle.uis.edu");

if (!$connection) {

echo "Couldnt make a connection!";

exit;

}



$sqlquery = " SELECT passenger,class,sex,age,survived FROM TITANIC WHERE survived ='Yes' order by Sex,AGE" ;

$sql_id = ociparse($connection, $sqlquery);

if (!$sql_id) {

$e= oci_error ($connection);

print htmlentities($e['message']);

exit;

}

ociexecute($sql_id , OCI_DEFAULT);

  //print "<background-image: url(\"Titanic.jpeg\")>\n";



  print "<marquee> <p style=\"font-size:30px; color: red\"> <b> Details of the survivors from the TITANIC. </p></b> </marquee> \n"; 

    print "<table border=\"2\" style= \"background-color: #b0c4de; color: black; margin: 0 auto;\" >\n";

   print "  <TR><TH>PASSENGER</TH><TH>SEX</TH><TH>AGE</TH><TH>SURVIVED</TH></TR>\n";

while(OCIFetch($sql_id)) 

   { 

      print "  <TR>\n"; 

      print "    <TD>" . OCIResult($sql_id, "PASSENGER") . "</TD>\n"; 

      print "    <TD>" . OCIResult($sql_id, "SEX") . "</TD>\n"; 

	print "    <TD>" . OCIResult($sql_id, "AGE") . "</TD>\n"; 

	print "    <TD>" . OCIResult($sql_id, "SURVIVED") . "</TD>\n";       

print "  </TR>\n"; 

   }



   print "\n";

ocilogoff($connection);

?>

</body>

</html>

