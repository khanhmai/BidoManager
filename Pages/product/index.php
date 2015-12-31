<?php include '../../Connection.php' ?>
<?php include '../../Util.php' ?>
<?php include '../../Template/top.php'?>
<?php
session_start();
?>
<html lang="en">
    <?php G_Head(0);?>
    
<!-- Start main page -->
    
<?php 
$connection = getConnection();
$query = "call Product_GetAll()";
mysql_query("SET NAMES utf8");
$result = mysql_query($query);

echo $connection;

echo '<div><table class="table table-hover table-bordered">'
 . '<tbody><tr style="background: aquamarine;">'
        . '<th>Image</th>'
        . '<th>Name</th>'
        . '<th>Style</th>'
        . '<th>Weight</th>'
        . '<th> </th>'
        . '<th> </th></tr>';

while($row = mysql_fetch_array($result)){
?>
    <tr>
        <td>
            <img class="imageproduct" src="<?=$row['Image']?>" alt="<?=$row['Name']?>"/>
        </td>
        
        <td >
            <?=$row['Name']?>
        </td>
        <td >
            <?=$row['Style']?>
        </td>
        
        <td >
            <?=$row['Weight']?>
        </td>
        <td >
            <img src="../icon/delete-icon.png" alt="Delete" class="icon" 
                 onclick="gotoByUrl('Ban muốn xóa <?=$row['Name']?>', 
                             '<?= $_SERVER['HTTP_HOST'].'/'.$currentFolder?>/product/index.php?deleteId=<?=$row['Id']?>')"/>
            <a href ="http://<?= $_SERVER['HTTP_HOST'].'/'.$currentFolder?>/product/edit.php?editId=<?=$row['Id']?>"/>
               <img src="../icon/edit-icon.png" alt="Edit" class="icon"/>
            </a>                 
        </td>   
        <td >
            <a href ="http://<?= $_SERVER['HTTP_HOST'].'/'.$currentFolder?>/order/edit.php?productId=<?=$row['Id']?>"/>
               <img src="../icon/shopping-icon.png" alt="Order" class="icon"/>
            </a>  
        </td>
    </tr>
        
<?php
    }
    echo '</tbody></table></div>';
    mysql_close($connection);
?>

    
</div><!-- End main page -->

<?php include '../../Template/bottom.php'?>