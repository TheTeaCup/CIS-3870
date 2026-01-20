<html>
<body>

<!-- a P tag has crlf after it normally -->
<p>You entered:</p>

<!-- 
!!! the code form w3schools enabled cross site scripting which is a valnerbility...
The ?php tag starts the section of php code and end the section with ? 
echo command tells the server to print/send that text to the client (as html or whatever the form of the file is)
$_POST is an array that contains all the submitted data from the client using the POST command
["RecipeID"] references that part of the array and gets the data 
-->
RecipeID: <?php echo htmlspecialchars($_POST["RecipeID"]); ?><br>
RecipeTitle: <?php echo htmlspecialchars($_POST["RecipeTitle"]); ?><br>
RecipeDesc: <?php echo htmlspecialchars($_POST["RecipeDesc"]); ?><br>
MakesQty: <?php echo htmlspecialchars($_POST["MakesQty"]); ?><br>
MakesType: <?php echo htmlspecialchars($_POST["MakesType"]); ?><br>
PrepMins: <?php echo htmlspecialchars($_POST["PrepMins"]); ?><br>
Category: <?php echo htmlspecialchars($_POST["Category"]); ?><br>
Picture: <?php echo htmlspecialchars($_POST["Picture"]); ?><br>

</body>
</html>