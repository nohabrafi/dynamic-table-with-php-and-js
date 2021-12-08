<html>
    <head>
        <meta charset = "UTF-8">
        <title>Prozesswerte</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

   
    <body>
        <h1>Prozesswerte Tabelle</h1>
        <button type="button" onclick="start()">Start</button> <!-- start update -->
        <button type="button" onclick="stop()">Stop</button> <!-- stop update -->

    <?php

        // mit datenbank verbinden
        $mysqli = new mysqli("localhost", "root","", "rooms");

        // Verbindung kontrollieren, wenn passt in console anzeigen
        if($mysqli -> connect_error){
            exit("Can't connect to server because: " . $mysqli->connect_error);
        } else {
            printf("<script>console.log('Connected to server!')</script>");
        }

        // charset wegen Umlauten
        $mysqli->set_charset("utf8"); 
        
        // Query, wenn es geht in console anzeigen
        if(!$results = $mysqli->query("SELECT * FROM werte")){
            exit("Query failed because: " . mysqli_error($mysqli));
        } else {
            print "<script>console.log('Query successful!')</script>";
        }
   
        // Daten in Tabelle anzeigen
        /*
        <th></th> -> head der Tabelle
        <tr></tr> -> eine Zeile
        <td></td> -> daten in eine Zeile        
        */

        // creat the table with php
        
        print "<table>";
            // head der Tabelle
            print "<tr>";
                print "<th>ID</th>";
                print "<th>Raum</th>";
                print "<th>Wert</th>";
                print "<th>Einheit</th>";
                print "<th>Feuchtigkeit</th>";
            print "</tr>";

            // alle elemente von array $row in neue zeile schreiben 
            while($row = $results->fetch_assoc()){
                $id = $row['id'];
                print "<tr>";
                    print "<td>"; print $row['id']; print "</td>";
                    print "<td>"; print $row['name']; print "</td>";
                    print "<td id = 'wert_$id'>"; print $row['wert']; print "</td>";
                    print "<td>"; print $row['einheit']; print "</td>";
                    print "<td id = 'humidity_$id'>"; print $row['humidity']."%"; print "</td>";                  
                print "</tr>";
            }    

        print "</table>";
        
        $mysqli->close(); // close connection to DB 
    ?>

     <script>
         /* initiating the value updates and manipulating
            the look of the table with javascript */

        var x = 0;
        var interval = 0;

        // start interval
        function start(){
            interval = setInterval(request_xml, 1000);
        }

        // stop interval
        function stop(){
            clearInterval(interval);
        }
        
        // request the data from database
        function request_xml(){ 
            xmlhttpr = new XMLHttpRequest();
            xmlhttpr.open("GET", "update.php", true);
            xmlhttpr.send();
            xmlhttpr.onreadystatechange = changecontent;
        }

        function changecontent(){

            if(xmlhttpr.readyState == 4 && xmlhttpr.status == 200){
                
                var xml_response = xmlhttpr.responseXML;
                var roomNodes = xml_response.getElementsByTagName("room");
                x++;

                // refresh humidity only every fifth second
                if(x == 5){
                    
                    // loop through the nodes of the response XML
                    for(i = 0; i < roomNodes.length; i++){
                    
                        var id = roomNodes[i].getAttribute('id');

                        /*
                        var temperatur = roomNodes[i].getElementsByTagName('data')[0].getElementsByTagName('temperatur')[0].getAttribute('value');
                        var humidity = roomNodes[i].getElementsByTagName('data')[0].getElementsByTagName('humidity')[0].getAttribute('value');
                        */

                        // get the value from the XML
                        // same as the commented variant above
                        var temperatur = roomNodes[i].getElementsByTagName('data')[0].childNodes[0].getAttribute('value');
                        var humidity = roomNodes[i].getElementsByTagName('data')[0].childNodes[1].getAttribute('value');

                        // get the correct HTML element by id 
                        var tempwert = document.getElementById('wert_'+id);
                        var humiwert = document.getElementById('humidity_'+id);

                        // display the values
                        //humiwert.innerHTML = humidity+'%';
                        $("#humidity_"+id).html(humidity + "%");
                        tempwert.innerHTML = temperatur;
                        
                        // change colors if necessary
                        if (temperatur > 30)
                            tempwert.style.backgroundColor = "#ffb8b8";
                        else if (temperatur < 20)   
                            tempwert.style.backgroundColor = "#b8d1ff";
                        else{
                            if(id % 2 == 0)
                                tempwert.style.backgroundColor = "#cacaca";
                            else
                                tempwert.style.backgroundColor = "#ffd699";
                            }
                            
                            x = 0;
                        }

                } else {

                    for(i = 0; i < roomNodes.length; i++){

                        var id = roomNodes[i].getAttribute('id');

                        /*
                        var temperatur = roomNodes[i].getElementsByTagName('data')[0].getElementsByTagName('temperatur')[0].getAttribute('value');
                        var humidity = roomNodes[i].getElementsByTagName('data')[0].getElementsByTagName('humidity')[0].getAttribute('value');
                        */

                        // get the value from the XML
                        var temperatur = roomNodes[i].getElementsByTagName('data')[0].childNodes[0].getAttribute('value');

                        // get the correct HTML element by id 
                        var tempwert = document.getElementById('wert_'+id);

                        // display the values
                        tempwert.innerHTML = temperatur; 
                        
                        // change colors if necessary
                        if (temperatur > 30)
                        tempwert.style.backgroundColor = "#ffb8b8";
                        else if (temperatur < 20)   
                        tempwert.style.backgroundColor = "#b8d1ff";
                        else{
                            if(id % 2 == 0)
                                tempwert.style.backgroundColor = "#cacaca";
                            else
                                tempwert.style.backgroundColor = "#ffd699";
                        }
                    }  
                }     
            }      
        }
    </script>
    </body>    
</html>