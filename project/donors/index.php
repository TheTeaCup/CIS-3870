<?php 
   include 'page-header.php'; 
   echo PageHeader("Directory"); 
   ?>

<div class="center">
   <h1>List of Donors</h1>
</div>
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
            <th>Generate Receipt</th>
            <th>Generate Letter</th>
         </tr>
      </thead>
      <tbody>
         <!-- PHP rows go here -->
      </tbody>
   </table>
</div>

<div class="center">
   <h1>List of Donated Items</h1>
</div>
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
         <!-- PHP rows go here -->
      </tbody>
   </table>
</div>

<div class="center">
   <h1 style="color: red">
      List of Donors who have not Received a tax receipt
   </h1>
</div>
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
            <th class="red">Generate Receipt</th>
            <th class="red">Generate Letter</th>
         </tr>
      </thead>
      <tbody>
         <!-- PHP rows go here -->
      </tbody>
   </table>
</div>
