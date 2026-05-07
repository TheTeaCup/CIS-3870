<?php
$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_ro";
$password = "asd";
$dbname = "wilsonhl6_db";
try {
   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   die("Could not connect. " . $e->getMessage());
}

include 'page-header.php';
echo PageHeader("Directory");
?>

<div class="center">
   <h1>List of Donors</h1>
</div>
<?php
try {
   $sql = "SELECT DonorID, BusinessName, ContactName, ContactEmail, ContactTitle, Address, City, State, ZipCode, TaxReceipt FROM Donor";
   $result = $conn->query($sql);
   ?>
   <div class="table-container">
      <table>
         <thead>
            <tr>
               <th>Donor ID</th>
               <th>Business Name</th>
               <th>Contact Name</th>
               <th>Contact Email</th>
               <th>Contact Title</th>
               <th>Address</th>
               <th>City</th>
               <th>State</th>
               <th>Zip Code</th>
               <th>Tax Receipt</th>
               <th>Update</th>
               <th>Delete</th>
               <th>Mark Receipt as Sent</th>
            </tr>
         </thead>
         <tbody>
            <?php
            if ($result->rowCount() > 0) {
               foreach ($result as $row) {
                  // PHP rows go here
                  echo "<tr>";
                  echo "<td>" . $row["DonorID"] . "</td>";
                  echo "<td>" . $row["BusinessName"] . "</td>";
                  echo "<td>" . $row["ContactName"] . "</td>";
                  echo "<td>" . $row["ContactEmail"] . "</td>";
                  echo "<td>" . $row["ContactTitle"] . "</td>";
                  echo "<td>" . $row["Address"] . "</td>";
                  echo "<td>" . $row["City"] . "</td>";
                  echo "<td>" . $row["State"] . "</td>";
                  echo "<td>" . $row["ZipCode"] . "</td>";
                  echo "<td>" . ($row["TaxReceipt"] ? "Yes" : "No") . "</td>";
                  echo "<td><a href='update-donor.php?DonorID=" . $row["DonorID"] . "'>Update</a></td>";
                  echo "<td><a href='delete-donor.php?DonorID=" . $row["DonorID"] . "'>Delete</a></td>";
                  echo "<td><a href='mark-receipt-sent.php?DonorID=" . $row["DonorID"] . "'>Mark Receipt as Sent</a></td>";
                  echo "</tr>";

               }
               unset($result);
            } else {
               echo "<tr><td colspan='4'>No records found.</td></tr>";
            }
} catch (PDOException $e) {
   echo "Error: " . $e->getMessage();
}

?>

      </tbody>
   </table>
</div>

<div class="center">
   <h1>List of Donated Items</h1>
</div>
<?php
try {
   $sql2 = "SELECT ItemID, Description, RetailValue, DonorID, LotID FROM Item";
   $result2 = $conn->query($sql2);
   ?>

   <div class="table-container">
      <table>
         <thead>
            <tr>
               <th>Donor ID</th>
               <th>Item ID</th>
               <th>Description</th>
               <th>Retail Value</th>
               <th>Update</th>
               <th>Delete</th>
            </tr>
         </thead>
         <tbody>
            <?php
            if ($result2->rowCount() > 0) {
               foreach ($result2 as $row) {
                  //PHP rows go here
                  echo "<tr>";
                  echo "<td>" . $row["DonorID"] . "</td>";
                  echo "<td>" . $row["ItemID"] . "</td>";
                  echo "<td>" . $row["Description"] . "</td>";
                  echo "<td>" . $row["RetailValue"] . "</td>";
                  echo "<td><a href='update-item.php?ItemID=" . $row["ItemID"] . "'>Update</a></td>";
                  echo "<td><a href='delete-item.php?ItemID=" . $row["ItemID"] . "'>Delete</a></td>";
                  echo "</tr>";
               }
               unset($result2);
            } else {
               echo "<tr><td colspan='4'>No records found.</td></tr>";
            }
} catch (PDOException $e) {
   echo "Error: " . $e->getMessage();
}

?>
      </tbody>
   </table>
</div>

<div class="center">
   <h1 style="color: red">
      List of Donors who have not Received a tax receipt
   </h1>
</div>

<?php
try {

   $sql3 = "SELECT DonorID, BusinessName, ContactName, ContactEmail,
            ContactTitle, Address, City, State, ZipCode, TaxReceipt
            FROM Donor
            WHERE TaxReceipt = 0";

   $result3 = $conn->query($sql3);

   ?>
   <div class="table-container">
      <table>
         <thead>
            <tr>
               <th class="red">Donor ID</th>
               <th class="red">Business Name</th>
               <th class="red">Contact Name</th>
               <th class="red">Contact Email</th>
               <th class="red">Contact Title</th>
               <th class="red">Address</th>
               <th class="red">City</th>
               <th class="red">State</th>
               <th class="red">Zip Code</th>
               <th class="red">Tax Receipt</th>
               <th class="red">Update</th>
               <th class="red">Delete</th>
               <th class="red">Mark Receipt as Sent</th>
            </tr>
         </thead>
         <tbody>
            <?php
            if ($result3->rowCount() > 0) {
               foreach ($result3 as $row) {
                  // PHP rows go here
                  echo "<tr>";
                  echo "<td>" . $row["DonorID"] . "</td>";
                  echo "<td>" . $row["BusinessName"] . "</td>";
                  echo "<td>" . $row["ContactName"] . "</td>";
                  echo "<td>" . $row["ContactEmail"] . "</td>";
                  echo "<td>" . $row["ContactTitle"] . "</td>";
                  echo "<td>" . $row["Address"] . "</td>";
                  echo "<td>" . $row["City"] . "</td>";
                  echo "<td>" . $row["State"] . "</td>";
                  echo "<td>" . $row["ZipCode"] . "</td>";
                  echo "<td>" . ($row["TaxReceipt"] ? "Yes" : "No") . "</td>";
                  echo "<td><a href='update-donor.php?DonorID=" . $row["DonorID"] . "'>Update</a></td>";
                  echo "<td><a href='delete-donor.php?DonorID=" . $row["DonorID"] . "'>Delete</a></td>";
                  echo "<td><a href='mark-receipt-sent.php?DonorID=" . $row["DonorID"] . "'>Mark Receipt as Sent</a></td>";
                  echo "</tr>";

               }
               unset($result3);
            } else {
               echo "<tr><td colspan='4'>No records found.</td></tr>";
            }
} catch (PDOException $e) {
   echo "Error: " . $e->getMessage();
}

$conn = null;
?>
      </tbody>
   </table>
</div>