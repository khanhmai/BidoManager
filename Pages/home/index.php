<!DOCTYPE html>
<?php include '../../Connection.php' ?>
<?php include '../../Util.php' ?>
<?php include '../../DAL/OrderDAL.php' ?>

<?php
session_start();
?>

<?php
if (isset($_POST["login"])) {

    $connection = getConnection();

    $username = $_POST["username"];
    $password = $_POST["pass"];

    $query = "Select * FROM User Where `username` = '$username' AND `password` = '$password'";

    $result = mysql_query($query);

    if (!$result) {
        $message = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    $num_rows = mysql_num_rows($result);

    //echo "result: ".$num_rows;

    if ($num_rows < 1) {
        $_SESSION["IDUSER"] = -1;
    } else {
        $row = mysql_fetch_array($result);


        $_SESSION["IDUSER"] = $row['Id'];

        if (!is_null($row['Id'])) {
            $_SESSION["Name"] = $row['Name'];
            $_SESSION["Level"] = $row['Level'];
        }
    }
    mysql_close($connection);
} else if (isset($_POST["logout"])) {
    $_SESSION["IDUSER"] = -1;
    $_SESSION["Name"] = "";
    $_SESSION["Level"] = "";
}
?>


<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">

        <title>Hệ thống quản lý Bido-Shop</title>

        <!-- Bido CSS -->
        <link href= "../../Resources/bidostyle.css" rel="stylesheet"/>

        <!-- Bido script -->
        <script src="../../Resources/bidoscript.js"></script>
        <script src="../../Resources/graph.js"></script>
        <script src="http://d3js.org/d3.v3.min.js"></script>

        <!-- Bootstrap core CSS -->
        <link href= "../../bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../../bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet"/>

        <!-- Custom styles for this template -->
        <link href="../../bootstrap/css/jumbotron.css" rel="stylesheet"/>

        <script type="text/javascript">
            function updateResize() {
                $("#dashboard").remove();
                $("#chart").append("<div id='dashboard' style=\"margin-left: auto; margin-right: auto; width:" + $("#chart").width() + "px\"></div>");
                dashboard('#dashboard', freqData, $("#chart").width());
            }
        </script>

    </head>

    <body onresize="updateResize()">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><div style="display:inline;"><img src="../../Resources/logo.png" height="24px" align="middle"></div>
                        <div style="display:inline; font-size: 20px; margin-top: 5px">Bido-Shop</div></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <form method="post" class="navbar-form navbar-right">

                        <?php if (!isset($_SESSION["IDUSER"]) || (isset($_SESSION["IDUSER"]) && $_SESSION["IDUSER"] == -1)) { ?>

                            <!-- Show login fields -->

                            <div class="form-group">
                                <input name="username" type="text" placeholder="Email" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="pass" type="password" placeholder="Password" class="form-control">
                            </div>
                            <button type="submit" name = "login" class="btn btn-success">Sign in</button>

                        <?php } else { ?>


                            <div class="form-group">
                                <span  style="color:white">Xin chào <?= $_SESSION["Name"] ?></span>
                                <button type="submit" name="logout" class="btn btn-success">Log out</button>
                            </div>
                        <?php } ?>
                    </form>
                    <?php if (isset($_SESSION["IDUSER"]) && isset($_SESSION["Level"]) && $_SESSION["IDUSER"] != -1) { ?>
                        <div class="form-group">
                            <nav style="padding-top: 5px">
                                <ul class="nav nav-justified">
                                    <?php if ($_SESSION["Level"] == 0) { ?>

                                        <li class="livenav"><a href="../product">Products</a></li>
                                        <li class="livenav"><a href="#">Customers</a></li>
                                        <li class="livenav"><a href="#">Order</a></li>
                                        <li class="livenav"><a href="#">Packages</a></li>
                                        <li class="livenav"><a href="#">Update</a></li>
                                        <li class="livenav"><a href="#">Đóng hàng</a></li>
                                        <li class="livenav"><a href="#">Danh sách</a></li>
                                    <?php } ?>
                                    <?php if ($_SESSION["Level"] == 1) { ?>
                                        <li class="livenav"><a href="#">Profit</a></li>
                                        <li class="livenav"><a href="#">Chuyển tiền</a></li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                    <?php } ?>

                </div><!--/.navbar-collapse -->
            </div>
        </nav>

        <?php UpdateTax(); ?>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <h1>Tiền Trôi nổi: <?php echo formatMoney(tienTroiNoi()); ?> <img src="../../Resources/vnd.png" height="45px"></h1>
                <p>Đây là tổng số tiền của những sản phẩm đã được đóng hàng (chưa chuyển hoặc đã chuyển) nhưng chưa về đến VN.</p>
                <p><a class="btn btn-primary btn-lg" role="button" onclick="toggler('reportOrder');">Chi tiết &raquo;</a></p>
                <div id="reportOrder" class="hidden">
                    <?php reportOrder(-1); ?>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">

                <h2>Báo cáo chi tiết</h2>
                <p>Dưới đây là bảng báo cáo tình hình thu và chi của Bido-Shop theo từng tháng. Chưa tính lương nhân viên</p>

                <?php $freqData = listIncome('2015'); ?>
            </div>

            <div class="row" id="chart">
                <div id='dashboard'>                

                </div>
            </div>
            <hr>

            <footer>
                <p>&copy; 2015 Bido-Shop, Inc.</p>
            </footer>
        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->


    </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>');</script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script>
                    var freqData = <?php echo $freqData ?>;
                    dashboard('#dashboard', freqData, $("#chart").width());
</script>