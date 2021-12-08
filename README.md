This project is about dynamically refreshing the data that is displayed in a table. Initially when the page is loaded the PHP section gets the data from
the database and creates the table with the values. When the start button is pressed the javascript part begins to send an XMLHttpRequest on the update.php url
in order to get fresh data. If the data returns, the table that has been created earlier will be filled with the new values.

The update.php file creates new random values and updates these in the database. After that, it returns the fresh data in XML format which can be processed
by the javascript. 
