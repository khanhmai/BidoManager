<?php

function G_Head($level) { ?>

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
    </head>
    
    <body>
        <?php G_Menu($level) ?>
    
<?php } ?>


<?php

function G_Menu($level) { ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../../index.php"><div style="display:inline;"><img src="../../Resources/logo.png" height="24px" align="middle"></div>
                    <div style="display:inline; font-size: 20px; margin-top: 5px">Bido-Shop</div></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <form method="post" class="navbar-form navbar-right">

                    <?php if (!isset($_SESSION["IDUSER"]) || 
                            (isset($_SESSION["IDUSER"]) && ($_SESSION["IDUSER"] == -1 || $_SESSION["Level"] > $level))) { ?>

                        <?php
                        header('Location: ' . "../home");
                        //echo "<h1>".$_SESSION["IDUSER"]."</h1>";
                        ?>

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
        
        <div class="container">

<?php } ?>
