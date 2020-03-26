<?php       
    require('db_server.php'); //checkUser here
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="styles.css">

<style>
table, td {
  border: 1px solid black;
}
</style>
</head>
<body>

 <form action="createMember.php" method="post">
<?php
           
           
       //    callFunctions("fetchClubs", "list"); 
           
           
?>
<p>Click on each tr element to alert its index position in the table:</p>

<table>
  <tr onclick="myFunction(this)">
    <td>Click to show rowIndex</td>
  </tr>
  <tr onclick="myFunction(this)">
    <td>Click to show rowIndex</td>
  </tr>
  <tr onclick="myFunction(this)">
    <td>Click to show rowIndex</td>
  </tr>
</table>



<table border="1">
    <tr>
        <td>
            <input id="row-selector" type="checkbox"/>
        </td>
        <td class="row-value">Row #1: Hello</td>
    </tr>
    <tr>
        <td>
            <input id="row-selector" type="checkbox"/>
        </td>
        <td class="row-value">Row #2: World</td>
    </tr>
</table>

<button id="btn-table-rows">Process</button>

</form>

<script>
function setSelectedRow(x) {
  alert("Row index is: " + x.rowIndex);
}
</script>


<script>
$('#btn-table-rows').click(function (event) {
    var values = [];
    
    $('table #row-selector:checked').each(function () {
    	var rowValue = $(this).closest('tr').find('td.row-value').text();
    	values.push(rowValue)
    });
    
    var json = JSON.stringify(values);
    
    alert(json);
});

</script>


</body>
</html>
