<?php

require_once("../libs/common.php");

$mysqli = getDB();

$stmt = $mysqli->prepare("SELECT id, name, description, image, price FROM items WHERE id = ?");

$nItemId = 1;

if(array_key_exists("itemid", $_GET))
{
	$nItemId = $_GET["itemid"];
}

$stmt->bind_param("d", $nItemId);

$stmt->execute();

$itemset = $stmt->get_result();

$aItem = $itemset ->fetch_assoc();

$stmtColors = $mysqli ->prepare("SELECT color FROM item_colors WHERE itemid = ?");
$stmtColors->bind_param("d", $nItemId);
		
$stmtSizes = $mysqli ->prepare("SELECT size FROM item_sizes WHERE itemid = ?");
$stmtSizes ->bind_param("d",$nItemId);

?>

<!DOCTYPE html>
<html>
<head>
<title>Item Details for <?php echo $aItem["name"]?></title>
</head>
<body>
	<h1>
		Item Details for
		<?php echo $aItem["name"]?>
		(
		<?php echo $aItem["price"]?>
		)
	</h1>
	<p>
		<?php echo $aItem["description"]?>
	</p>
	<img alt="<?php echo $aItem["name"]?>"
		src="images/<?php echo $aItem["image"]?>" />
<?php 
 $stmtColors->execute();
 $colorsset = $stmtColors ->get_result();
 if($colorsset ->num_rows == 1)
 {
 	$aColor = $colorsset ->fetch_assoc();
 	echo "<p>This item comes in any color so long as it is ", $aColor["color"],"</p>";
 }
 else 
 { ?>
  <fieldset>
  <legend>color</legend>
  <?php 
  
  while($aColor = $colorsset ->fetch_assoc())
  {
  	echo "<p><input type = \"radio\" name=\"color\"value=\"", $aColor["color"],"\" />";
  	echo $aColor["color"],"</p>";
  }
  
  ?>
  </fieldset>
 	
 <?php }
 $stmtSizes->execute(); 
 $sizesset = $stmtSizes->get_result();
 if($sizesset->num_rows == 1)
 {
 	$aSize = $sizesset->fetch_assoc(); 
 	echo"<p>",$aSize["size"],"</p>";
 }
 else
 {?>
 <fieldset>
  <legend>Size</legend>
  <?php 
  while($aSize = $sizesset ->fetch_assoc())
  {
  	echo "<p><input type =\"radio\" name=\"size\"value=\"", $aSize["size"],"\" />";
  	echo $aSize["size"],"</p>";
  }
  
  ?>
  </fieldset>
  
   <?php }

?>
</body>
</html>
