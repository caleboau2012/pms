<?php
require_once '../_core/global/_require.php';
Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);

if(!CxSessionHandler::getItem(UserAuthTable::userid)){
    header("Location: ../index.php");
} else {
    $name = CxSessionHandler::getItem(ProfileTable::surname) . " " . CxSessionHandler::getItem(ProfileTable::middlename) . " " . CxSessionHandler::getItem(ProfileTable::firstname);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>PMS Mail</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">
    <link href="../css/bootstrap/datepicker.css" rel="stylesheet">
    <link href="../css/bootstrap/jquery-ui.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard.php">Patient Management System</a>
        </div>
        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li>
                    <a href="mails.php">
                        <span class="fa fa-envelope"></span>
                        <sup class="badge notification message_unread"></sup>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <img src="../images/profile.png">
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="dashboard.php">Dashboard</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 roster-sidebar">
            <a href="#myModal" class="btn btn-success btn-compose btn-block" data-toggle="modal">Compose</a>
            <ul class="list-group nav nav-tabs">
                <a id="inbox_tab" href="#inbox" class="list-group-item active" data-toggle="tab">
                    Inbox <span class="badge unread-count"></span>
                </a>
                <a id="sentmail_tab" href="#sentmails" class="list-group-item" data-toggle="tab">
                    Sent Mails
                </a>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10 pull-right put-margin-top">
            <div class="tab-content">
                <div id="inbox" class="tab-pane fade in active">
                    <div class="container-fluid empty-box-message hidden">
                        <h1>No messages to display!</h1>
                    </div>
                    <div class="container-fluid view-message hidden">
                        <ul class="pager messages-back">
                            <li class="previous back-button"><a href="#">&larr; Back</a></li>
                        </ul>
                    </div>
                    <div class="container-fluid message-pane">
                        <div class="panel panel-info">
                            <div class="panel-heading message-panel">
                                <h4 class="pull-left">Inbox</h4>
                                <span class="pull-right">
                                    <span class="start_index"></span>
                                    <span> &ndash; </span>
                                    <span class="end_index"></span>
                                    <span> of </span>
                                    <span class="total"></span>
                                    <span class="fa-stack fa-lg newer">
                                        <span class="fa fa-square fa-stack-2x"></span>
                                        <span class="fa fa-angle-left fa-stack-1x fa-inverse"></span>
                                    </span>
                                    <span class="fa-stack fa-lg older">
                                        <span class="fa fa-square fa-stack-2x"></span>
                                        <span class="fa fa-angle-right fa-stack-1x fa-inverse"></span>
                                    </span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover table-responsive message-list">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="sentmails" class="tab-pane fade">
                    <div class="container-fluid empty-box-message hidden">
                        <h1>No messages to display!</h1>
                    </div>
                    <div class="container-fluid view-message hidden">
                        <ul class="pager messages-back">
                            <li class="previous back-button"><a href="#">&larr; Back</a></li>
                        </ul>
                    </div>
                    <div class="container-fluid message-pane">
                        <div class="panel panel-info">
                            <div class="panel-heading message-panel">
                                <h4 class="pull-left">Inbox</h4>
                                <span class="pull-right">
                                    <span class="start_index"></span>
                                    <span> &ndash; </span>
                                    <span class="end_index"></span>
                                    <span> of </span>
                                    <span class="total"></span>
                                    <span class="fa-stack fa-lg newer">
                                        <span class="fa fa-square fa-stack-2x"></span>
                                        <span class="fa fa-angle-left fa-stack-1x fa-inverse"></span>
                                    </span>
                                    <span class="fa-stack fa-lg older">
                                        <span class="fa fa-square fa-stack-2x"></span>
                                        <span class="fa fa-angle-right fa-stack-1x fa-inverse"></span>
                                    </span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover table-responsive message-list">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="myModal" class="modal fade new-message-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">New Message</h4>
                    </div>
                    <div class="modal-body message-modal-body">
                        <form method="post">
                            <input name="send_mail_action" type="text" value="compose" hidden>
                            <div class="form-group ui-front">
                                <input type="text" class="form-control" name="recipient" placeholder="Recipient">
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <textarea rows="12" name="body" class="msg-body form-control" placeholder="Message"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary send-mail" name="Send" value="Send">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/jquery-ui.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/mail.js" type="text/javascript"></script>
<script type="text/javascript">
    (function($) {
        Mail.loadMessages();

        Mail.resource.setUsername("<?php echo $name; ?>");

        $("a[data-toggle='tab']").on('shown.bs.tab', function(event){
            Mail.removeMessagePane();

            var active_tab_link = $(event.target);
            var previous_tab_link = $(event.relatedTarget);

            active_tab_link.addClass("active");
            previous_tab_link.removeClass("active");


            var active_tab_id = active_tab_link.attr("href");
            var active_tab = $(active_tab_id);

            Mail.resource.current_page = 1;

            Mail.loadMessages(active_tab);
        });

        $("span.older").unbind('click').bind('click', function(event){
            if ($(this).hasClass("disabled_msg_nav_icon")) {
                event.preventDefault();
                return
            } else {
                Mail.resource.current_page = Mail.resource.current_page + 1;
                Mail.loadMessages();
            }
        });

        $("span.newer").unbind('click').bind('click', function(){
            if ($(this).hasClass("disabled_msg_nav_icon")) {
                event.preventDefault();
                return;
            } else {
                Mail.resource.current_page = Mail.resource.current_page - 1;
                Mail.loadMessages();
            }
        });

        $("input[name='recipient']").autocomplete({
            source : host + "phase/phase_communication.php?intent=searchContact",
            minLength : 0,
            select : function(event, ui) {
                $(this).attr("id", "user-" + ui.item.userid);
                $(this).val(ui.item.value);
                $(this).parent().removeClass("has-error");
                $(this).parent().addClass("has-success");
                return false;
            }
        });

        $("input[name='recipient']").on('keydown', function(key){
            if (key.which == 8 || key.which == 46) {
                $(this).removeAttr("id");
                $(this).parent().removeClass("has-success");
                $(this).parent().addClass("has-error");
            };
        })

        $("input.send-mail").unbind('click').bind('click', function(event){
            event.preventDefault();
            Mail.sendMail();
        });

        $(".new-message-modal").on('hidden.bs.modal', function () {
            Mail.clearModal();
        })

        $("textarea.msg-body").on('focus', function(){
            $("textarea.msg-body").setCursorPosition(1)
        });

        $("#myModal").on('shown.bs.modal', function(){
            $("input[name='recipient']").parent().removeClass("has-error");
            $("input[name='recipient']").parent().removeClass("has-success");
            $("input[name='send_mail_action']").val(Mail.resource.send_mail_action);
            console.log("Changing action to..." + Mail.resource.send_mail_action);
        })

        $("#myModal").on('hidden.bs.modal', function(){
            Mail.resource.send_mail_action = Mail.CONSTANTS.ACTION.COMPOSE;
        })
    })(jQuery);
</script>

<?php include('footer.php'); ?>

</body>
</html>
