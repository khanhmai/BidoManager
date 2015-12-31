<?php
    function tienTroiNoi(){
    	$connection = getConnection();       
        $query = "SELECT Sum(`SellPrice`) As 'troinoi' FROM `SellProduct` WHERE `CurrentState` < 7";
        $result = mysql_query($query);
        $rowC = mysql_fetch_array($result);
        $troinoi = $rowC['troinoi'];
        mysql_close($connection);
        return $troinoi;
    }
?>

<?php
    function reportOrder($productId){
        $connection = getConnection();
        if($productId != -1)
            $query = "SELECT `State`.`Id` , `State`.`Content` , Count( `Order`.`CurrentState` ) AS number
                    FROM (Select * From `SellProduct` where `ProductId` = $productId) As `Order`
                    RIGHT JOIN `State` ON  `Order`.`CurrentState` = `State`.`Id`
                    GROUP BY `State`.`Id`
                    ORDER BY `State`.`Id` ";
        else 
            $query = "SELECT `State`.`Id` , `State`.`Content` , Count( `SellProduct`.`CurrentState` ) AS number, Sum(`SellProduct`.`SellPrice`) AS Money
                    FROM `SellProduct`
                    RIGHT JOIN `State` ON `SellProduct`.`CurrentState` = `State`.`Id`
                    GROUP BY `State`.`Id` 
                    Order by `State`.`Id`";
        $result = mysql_query($query);    
        echo '<div><table class="table table-hover table-bordered">'
        . '<tbody><tr style="background: aquamarine;">'
        . '<th>State</th>'          
        . '<th>#Order</th>'
        . '<th>Money (VNĐ)</th></tr>';
        while($rowC = mysql_fetch_array($result)){?>
        <tr>
        
            <td >
                <?=$rowC['Content']?>
            </td>
            <td >
                <?=$rowC['number']?>
            </td>
            <td >
                <?= formatMoney($rowC['Money'])?>
            </td>
        </tr>
        <?php
        }
        echo '</tbody></table></div>';
        mysql_close($connection);
    }
?>

<?php
     function UpdateTax(){
        $connection = getConnection();
        $month = date("m");
        $query = "call UpdateTax($month)";  
        $result = mysql_query($query);
        mysql_close($connection);
     }
?>

<?php
    function listIncome($year){
        $connection = getConnection();
       
        $query = "SELECT 	MONTH(`SellProduct` .`DateOpen`) AS `Month`,
		YEAR(`SellProduct` .`DateOpen`) AS `Year`,
		ROUND(SUM(`SellProduct`.`BuyPrice`),2) AS `Buy`,
		ROUND(SUM(`Product`.`Weight`) * 4,2) AS `Shipping`,
		ROUND(SUM(`SellProduct`.`SellPrice`)) AS `Sell`,
		ROUND(SUM(`SellProduct`.`SellPrice`)
			- SUM(`SellProduct`.`BuyPrice`) * `SellProduct`.`Rate`
			- SUM(`Product`.`Weight`) * 4 * `SellProduct`.`Rate`
			- SUM(`SellProduct`.`Tax`) * `SellProduct`.`Rate`
			- SUM(`SellProduct`.`DeliFee`)
			,0) AS `Income`
		FROM `SellProduct` 
		INner Join `Product` ON `SellProduct`.`ProductId` = `Product`.`Id`
		WHERE `SellProduct`.`SellPrice` > 0 AND YEAR(`SellProduct` .`DateOpen`) = $year
		Group By MONTH(`SellProduct` .`DateOpen`), YEAR(`SellProduct` .`DateOpen`)"
		;
        $result = mysql_query($query);    
        $freqData = "[";
        echo '<div><table class="table table-hover table-bordered">'
        . '<tbody><tr style="background: aquamarine;">'
        . '<th>M</th>'
        . '<th>Year</th>'
        . '<th>Buy ($)</th>'
        . '<th>Ship ($)</th>'        
        . '<th>Sell (VND)</th>'
        . '<th>Profit (VND)</th></tr>';
        while($rowC = mysql_fetch_array($result)){?>
        <tr>
        
            <td >
                <?=$rowC['Month']?>
            </td>
            <td >
                <?=$rowC['Year']?>
            </td>
            <td >
                <?=formatMoney($rowC['Buy'])?>
            </td>
            <td >
                <?= formatMoney($rowC['Shipping'])?>
            </td>
            <td >
                <?= formatMoney(round($rowC['Sell']/1000))?> 
            </td>
            <td >
                <?= formatMoney(round($rowC['Income']/1000))?> 
            </td>
        </tr>
        <?php
        
        $freqData = $freqData."{State:'".$rowC['Month']."',freq:{ profit:".round($rowC['Income']/1000000).", cost:".round(($rowC['Sell']-$rowC['Income'])/1000000)."}},";
        }
        
        $freqData = trim($freqData, ",")."];";
        echo '</tbody></table></div>';
        mysql_close($connection);
        //echo $freqData;
        return $freqData;
    }
?>