<?php
    header('content-type: text/xml');
    $mysqli = new mysqli("localhost", "root", "", "rooms"); // connect to DB
    $result = $mysqli->query("SELECT * FROM werte"); // query everything from the table "werte"
    // loop through the results and update the values in the DB with another query
    while($row = $result->fetch_assoc()){
        $id = $row['id'];
        $min = $row['min_wert'];
        $max = $row['max_wert'];
        $val = rand(10*$min, 10*$max)/10;
        $hum = rand(100, 900)/10;
        $mysqli->query("UPDATE werte SET wert = $val, humidity = $hum WHERE werte.id = $id");
    }
    // return an XML containing the data
    print "<?xml version=\"1.0\"?>\n";
        print "<tags>";
            $results = $mysqli->query("SELECT * FROM werte"); // get the new values from DB
            while($row = $results->fetch_assoc()){
                $wert = number_format($row['wert'], 1);
                $humi = $row['humidity'];
                $id = $row['id'];
                $name = $row['name'];

                print "<room id = \"$id\" name = \"$name\">\n";
                    print "<data>";
                        print "<temperatur value = \"$wert\"/>";
                        print "<humidity value = \"$humi\"/>";
                    print "</data>";
                print "</room>";
            }
        print "</tags>";
        $mysqli -> close(); // close connection to DB
?>
