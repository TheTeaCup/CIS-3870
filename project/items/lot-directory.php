<?php

$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_ro";
$password = "asd";
$dbname = "wilsonhl6_db";

try {
   $conn = new PDO(
      "mysql:host=$servername;dbname=$dbname",
      $username,
      $password
   );

   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
   die("Could not connect. " . $e->getMessage());
}

include 'page-header.php';
echo PageHeader("Lot Directory");

?>

<div class="center">
   <h1>List of Lots</h1>
</div>

<?php

try {

   $sql = "SELECT
                LotID,
                Description,
                CategoryID,
                WinningBid,
                WinningBidder,
                Delivered
            FROM Lot";

   $stmt = $conn->prepare($sql);
   $stmt->execute();

   $lots = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
   die("Error retrieving lots: " . $e->getMessage());
}

?>

<div class="table-container">

   <table>

      <thead>
         <tr>
            <th>Lot ID</th>
            <th>Description</th>
            <th>Category ID</th>
            <th>Winning Bid</th>
            <th>Winning Bidder</th>
            <th>Delivery Status</th>
            <th>Assign Category</th>
            <th>Print Bidder Sheet</th>
            <th>Edit</th>
            <th>Delete</th>
         </tr>
      </thead>

      <tbody>

         <?php

         if (count($lots) > 0) {

            foreach ($lots as $row) {

               echo "<tr>";

               echo "<td>" . htmlspecialchars($row["LotID"]) . "</td>";
               echo "<td>" . htmlspecialchars($row["Description"]) . "</td>";
               echo "<td>" . htmlspecialchars($row["CategoryID"]) . "</td>";

               echo "<td>$" . number_format($row["WinningBid"], 2) . "</td>";

               echo "<td>";

               echo ($row["WinningBidder"] == null)
                  ? "No Winner"
                  : htmlspecialchars($row["WinningBidder"]);

               echo "</td>";

               echo "<td>";

               echo ($row["Delivered"])
                  ? "Delivered"
                  : "Not Delivered";

               echo "</td>";

               echo "<td>
                        <a href='assign-category.php?LotID={$row["LotID"]}'>
                            Assign Category
                        </a>
                     </td>";

               echo "<td>
                        <a href='print-bidder-sheet.php?LotID={$row["LotID"]}'>
                            Print Bidder Sheet
                        </a>
                     </td>";

               echo "<td>
                        <a href='update-lot.php?LotID={$row["LotID"]}'>
                            Edit
                        </a>
                     </td>";

               echo "<td>
                        <a href='delete-lot.php?LotID={$row["LotID"]}'>
                            Delete
                        </a>
                     </td>";

               echo "</tr>";
            }

         } else {
            echo "<tr><td colspan='9'>No lots found.</td></tr>";
         }

         ?>

      </tbody>

   </table>

</div>

<?php
$conn = null;
?>