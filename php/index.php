<?php 

require_once("../libs/common.php");

$mysqli = getDB();

$stmt = $mysqli->prepare("SELECT id, name, description, price FROM items WHERE categoryid = ?");

$nCategory = 1;

if(array_key_exists("categoryid", $_GET))
{
	$nCategory = $_GET["categoryid"];
}

 $stmt->bind_param("d",$nCategory);

if (!($res = $mysqli -> query("SELECT id, name, description FROM categories")))
{
	echo " CALL failed: (" . $mysqli ->errno . ") " . $mysqli ->error;
}
else
{
	
   ?>
<!Doctype html>
<html>
<head><title>Mr. T's t-shirts</title></head>
<body> 
<h1>Mr. T's t-shirts</h1>
<?php while($row = $res ->fetch_assoc())
	{
	   	 	?>
	   	 	
	   	 	<h2>
	   	 	<a href="?categoryid=<?php echo $row["id"]?>"><?php echo $row["name"]?></a>
	   	 	
	   	 	</h2>
	   	 	<p>
	   	 	    <?php echo $row["description"]?>
	   	 	</p>
	   	 	
	   	 	<?php 
	   	 	if($row["id"] == $nCategory)
	   	 	{
	   	 		$stmt ->execute();
	   	 		$itemset = $stmt ->get_result();
	   	 		while($itemRow = $itemset ->fetch_assoc())
	   	 		{
	   	 			?>
		      <p>
		         <a href ="itemdetails.php?itemid=<?php echo $itemRow["id"]?>"> <?php echo $itemRow["name"]?></a>
		          (
	              <?php echo $itemRow["price"]?>
		           )
		        </p>
		        <?php 
	   	 		}
	   	 	}
	   	 }
	}?>  
</body>
</html>