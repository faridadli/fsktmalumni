<?php 
//Add this file to open session for every file
require("sessionconfig.php");
//Add this file to use database for every file
include("../db.php");
//To return customer to feedback page if no data received
if (!isset($_GET['reportID'])) {
	header('Location: feedback.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>FSKTM Alumni</title>
        <!-- Favicon of the system !DO NOT REMOVE!-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/icon" />
        <!-- External styling -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css" media="all" />
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />
        <!-- External styling ends -->
        <!-- To style modal function -->
        <link rel="stylesheet" href="../assets/css/lunar.css" />
        <!-- Main style css file for all content !DO NOT REMOVE! -->
        <link rel="stylesheet" href="../assets/css/style.css" />
        <!-- To style table data -->
        <link rel="stylesheet" href="../assets/css/tablestyle.css" />
    </head>
    <header>
        <!-- Navigation start -->
        <div class="topnav">
            <div class="infotopnav">
                <h5>Welcome, <?php echo $_SESSION['username']?>!</h5>
            </div>
            <div class="btn-navbar">
                <a href="../logout.php" class="btn btn-3">
                    <span class="txt">Logout</span>
                    <span class="round"><i class="fa fa-chevron-right"></i></span>
                </a>
            </div>
        </div>

        <nav id="bottomnav">
            <div class="bottomnav">
                <img src="../images/logo.png" alt="logo" />
                <div class="topBotomBordersIn">
                    <a  href="index.php">HOME</a>
					<a href="manageuser.php">MANAGE USER</a>
                    <a href="event.php">EVENT</a>
					<a class="current" href="feedback.php">FEEDBACK</a>
                </div>
            </div>
        </nav>
        <!-- Navigation ends -->
    </header>

    <body>
        <div id="page">
            <!-- start of page content div -->
            <div class="row">
                <!-- Start row content -->
                <div class="container">
                    <!-- Back to previous page button -->
                    <a class="btn btn-primary" href="<?php echo $_SERVER["HTTP_REFERER"]?>" style="margin-top: 10px;">&#60;&nbsp;back</a>
                    <div class="profile-area">
                        <!-- Start Feature Content -->
                        <h2>Feedback</h2>
                        <div class="col">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="e-profile">
														<?php 
															$id = $_GET['reportID'];
															$stmt = $con->prepare("SELECT `name` , `email`, `feedback` FROM `feedback` WHERE id=$id");
															$stmt->execute();
															if($result = $stmt->get_result()){
																$row = $result->fetch_array(MYSQLI_ASSOC);
																$name = $row['name'];
																$email = $row['email'];
																$feedback = $row['feedback'];
															}else{
																header("Location: feedback.php");
																exit();
															}
														  ?>
                                                       <form action="../mailer/sendmail.php" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                    <input class="form-control" readonly="readonly" type="text" name="id" value="<?php echo $id?>" hidden/>
                                                <div class="form-group">
                                                    <label><strong>Reply to: </strong></label>
                                                    <input class="form-control" readonly="readonly" type="email" name="email" value="<?php echo $email?>"/>
                                                </div>
                                        </div>
											<div class="col">
                                                <div class="form-group">
                                                    <label><strong>Name: </strong></label>
                                                    <input class="form-control" readonly="readonly" type="name" name="name" value="<?php echo $name?>"/>
                                                </div>
                                        </div>
										</div>
                                        <div class="row">
											<div class="col">
                                                <div class="form-group">
                                                    <label><strong>Feedback: </strong></label>
                                                    <textarea class="form-control" type="text" rows="3" name="feedback" disabled><?php echo $feedback?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label><strong>Reply: </strong></label>
                                                    <textarea class="form-control" type="text" rows="4" name="reply"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<!-- Modal start -->
                            <!-- Modal for alert to modify user profile -->
                            <div class="modal fade" id="alertmessage" tabindex="-1" role="dialog" aria-labelledby="alertmessage" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="modal-body">
                                            <div class="px-3 pt-3 text-center">
                                                <div class="event-type warning">
                                                    <div class="event-indicator">
                                                        <svg style="width: 60px; height: 60px;" viewBox="0 0 24 24">
                                                            <path fill="#000000" d="M11,4.5H13V15.5H11V4.5M13,17.5V19.5H11V17.5H13Z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <br />
                                                <br />
                                                <h5>Are you sure to change?</h5>
                                                <p style="text-align: center;">This action cannot be undone.</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-cstm-danger" id="submitForm" type="submit">Continue</button>
                                            <a href="#" class="btn btn-cstm-secondary" data-dismiss="modal" aria-label="Close">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                                                        <div class="row">
                                                            <div class="col d-flex justify-content-end">
                                                                <button class="btn btn-primary" data-toggle="modal" data-target="#alertmessage"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Send</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- form for the user ends -->
							
                            <!-- End Feature Content -->
                        </div>
                    </div>
            <!-- End of row content -->
        </div>
        <!-- End of page content div -->

        <!-- Back to top function -->
        <a id="back2Top" title="Back to top" href="#">Back to top</a>
        <!-- SCRIPTS -->
        <script src="../assets/js/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!--For navigation animation-->
        <script src="../assets/js/lunar.js"></script>
        <!-- For modal design -->
        <script type="text/javascript" src="../assets/js/validator.js"></script>
        <script type="text/javascript" src="../assets/js/backtotopscroll.js"></script>
        <!-- For back to top function -->
    </body>
    <!-- Site footer -->
    <footer>
        <div class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p>Copyright &copy; 2021 Web Programming Project</p>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <ul class="social-icons">
                            <li>
                                <a class="facebook" href="https://www.facebook.com/CARIAUM"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a class="twitter" href="https://twitter.com/unimalaya"><i class="fa fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer ends -->
</html>

