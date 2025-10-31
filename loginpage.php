<?php
    session_start();
    if(!file_exists("../ipaddress.txt")){
        file_put_contents("../ipaddress.txt", "localhost");
    }
    $open = fopen("../ipaddress.txt", 'r');
    $size = filesize("../ipaddress.txt");
    $txtIPAddress = str_replace("\n", "", fread($open, $size));
    fclose($open);
    $_SESSION['GS-MMS'] = $txtIPAddress;
    if(isset($_SESSION['MMS-UserID'])){
        header('Location:index.php');
    }
    include('connect.php');
    $systype = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup", $connection));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Login Page</title>
        <link rel="stylesheet" href="assets/css/loginstyle.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome-animation.min.css" />
        <!-- <link href="//fonts.googleapis.com/css?family=Roboto:100italic,100,300italic,300,400italic,400,500italic,500,700italic,700,900italic,900" rel="stylesheet" type="text/css"> -->

        <!-- text fonts -->
        <!-- <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" /> -->
        <!--<link rel="shortcut icon" type="images/x-icon" href="assets/images/ai1logo.png" />-->
        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <link rel="stylesheet" href="assets/css/stylengtable.css" />
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

        <!-- ace settings handler -->
        <script src="assets/js/jquery-2.1.4.min.js"></script>
        <script async src="assets/js/ace-extra.min.js"></script>
        <script async src="assets/js/moment.min.js"></script>
        <script async src="assets/js/bootstrap.min.js"></script>
        <script async src="assets/js/jquery-ui.custom.min.js"></script>
        
        <!-- ace scripts -->
        <script async src="assets/js/ace-elements.min.js"></script>
        <script async src="assets/js/ace.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="col-md-6 col-md-offset-3" id="loginbody">
                    <div class="col-md-3" >
                        <center>
                            <!--<img src="assets/images/ai1logo.png" style="width: 120px;">-->
                            <!--<p style="padding: auto; color: #286090;" id="paragraphpo">
                                <small style="font-size: 12px;">Gatessoft Corp.<br />
                                Copyright 2018<br />
                                </small>
                            </p>-->
                        </center>
                    </div>
                    <div class="col-md-9" style="margin-top: 40px;">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="form-label col-md-3" for="txtUsername">Username</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtUsername" autocomplete="off" style="box-shadow: 0 7px 6px -6px #777;" class="txtLoginReq form-control" id="txtUsername" required onchange="fncShowSelect();" onkeyup="fncShowSelect();">
                                    <span class="glyphicon glyphicon-user form-control-feedback" style="margin-right: 15px; color: #286090;"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label col-md-3" for="txtPassword">Password</label>
                                <div class="col-md-8">
                                    <input type="password" autocomplete="off" name="txtPassword" style="box-shadow: 0 7px 6px -6px #777;" class="txtLoginReq form-control" id="txtPassword" required>
                                    <span class="glyphicon glyphicon-lock form-control-feedback" style="margin-right: 15px; color: #286090;"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label col-md-3" for="txtProperty">
                                <?php if($systype[0] == 0){ ?> Mall <?php }else if($systype[0] == 1){ ?> Property <?php }else if($systype[0] == 2){ ?> Building <?php }else if($systype[0] == 3){ ?> Palengke <?php }else if($systype[0] == 4){ ?> Cemetery <?php }else if($systype[0] == 5){ ?> Property <?php }else{ ?> Mall <?php } ?>
                                </label>
                                <div class="col-md-8">
                                    <select name="txtProperty" style="box-shadow: 0 7px 6px -6px #777;" class="txtLoginReq form-control" id="txtProperty" required>
                                        <?php if($systype[0] == 0){ ?> <option value=''>-- Select Mall --</option>Mall <?php }else if($systype[0] == 1){ ?> <option value=''>-- Select Property --</option> <?php }else if($systype[0] == 2){ ?> <option value=''>-- Select Building --</option> <?php }else if($systype[0] == 3){ ?> <option value=''>-- Select Palengke --</option> <?php }else if($systype[0] == 4){ ?> <option value=''>-- Select Cemetery --</option> <?php }else if($systype[0] == 5){ ?> <option value=''>-- Select Property --</option> <?php }else{ ?> <option value=''>-- Select Mall --</option> <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-3">
                                    <button class="col-md-12 btn btn-primary btn-sm btn-block btn-round" onclick="fncTryLogin();">LOGIN</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $("#txtUsername").keyup(function(e){
                var x = event.keyCode;
                if(x == 13){ 
                    fncTryLogin(); 
                }
            });
            $("#txtPassword").keyup(function(e){
                var x = event.keyCode;
                if(x == 13){ 
                    fncTryLogin(); 
                }
            });
            $("#txtProperty").keyup(function(e){
                var x = event.keyCode;
                if(x == 13){ 
                    fncTryLogin(); 
                }
            });

            function fncShowSelect(){
                var Username = $("#txtUsername").val();
                $.ajax({
                    type: 'POST',
                    url: 'mainclass.php',
                    data: 'Username=' + encodeURIComponent(Username) + '&form=fncShowSelect',
                    success: function(data){
                        $("#txtProperty").html(data);
                    }
                })
            }

            function fncTryLogin(){
                var Username = $("#txtUsername").val();
                var Password = $("#txtPassword").val();
                var Property = $("#txtProperty").val();
                $(".txtLoginReq").each(function(){
                    if($(this).val() == ""){
                        $(this).css("border-color", "#f2a696");
                    }else{
                       $(this).css("border-color", "#b5b5b5");
                    }
                })
                $.ajax({
                    type: 'POST',
                    url: 'mainclass.php',
                    data: 'Username=' + encodeURIComponent(Username) + '&Password=' + encodeURIComponent(Password) + '&Property=' + encodeURIComponent(Property) + '&form=fncTryLogin',
                    success: function(data){
                        var arr = data.split("|");
                        if(arr[0] == 1){
                            window.location = 'index.php';
                        }else{
                            setTimeout(function(){ 
                                showmodal('alert', arr[1], '', null, '', null, '1'); 
                            }, 1000)
                        }
                    }
                })
            }

            $(document).keydown(function(e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (e.altKey && code == 85 && e.shiftKey) {
                    $("#UpdateAuth").modal("show");
                    $("#txtAlterPass").keyup(function(e){
                        var x = event.keyCode;
                        if(x == 13){ 
                            confirmAlterDB(); 
                        }
                    });
                    setTimeout(function(){
                        $("#txtAlterPass").focus();
                    }, 1000)
                }
            });

            function confirmAlterDB(){
                var Auth = $("#txtAlterPass").val();
                $.ajax({
                    type: 'POST',
                    url: 'mainclass.php',
                    data: 'Auth=' + encodeURIComponent(Auth)  + '&form=TestInput',
                    success:function(data){
                        if(data == '1'){
                            $("#UpdateAuth").modal("hide");
                            setTimeout(function(){ 
                                showmodal("confirm", "Altering your database may cause a malfunction on your system, do you want to proceed?", "ProceedAlterDB", null, "", null, "1"); 
                            }, 500)
                        }else if(data == 2){
                            window.location = 'index.php';
                        }else{
                            $("#UpdateAuth").modal("hide");
                            setTimeout(function(){ 
                                showmodal("alert", "Wrong input cannot proceed.", "", null, "", null, "0"); 
                            }, 500);
                        }
                    }
                })
            }

            function ProceedAlterDB(){
                $("#txtAlterPass").val("");
                $.ajax ({
                    type: 'POST',
                    url: 'updatedb.php',
                    data: 'form=updatedb',
                    beforeSend: function() {
                        $(".loadingupdatedb").css("display", "block");
                    },
                    success: function(data) {
                        $(".loadingupdatedb").css("display", "none");
                    }
                })
            }

            $(document).keydown(function(e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (e.altKey && code == 65 && e.ctrlKey) {
                    $.ajax({
                        type: 'POST',
                        url: 'mainclass.php',
                        data: 'form=CheckPassword',
                        success: function(data){
                            if(data == 1){
                                $(".txtAlterPassAReq").val("");
                                $("#mdlAPass").modal("show");
                            }else{
                                $(".txtAlterPassAReq2").val("");
                                $("#mdlAPass2").modal("show");
                            }
                        }
                    })
                }
            });


            function fncAPass1(){
                var APass1 = $("#txtAlterAPass1").val();
                var APass2 = $("#txtAlterAPass2").val();
                var Count = 0;
                $(".txtAlterPassAReq").each(function(){
                    if($(this).val() == ""){
                        Count++;
                        $(this).css("border-color", "#f2a696");
                    }else{
                       $(this).css("border-color", "#b5b5b5");
                    }
                })
                if(Count == 0){
                    if(APass1 == APass2){
                        $.ajax({
                            type: 'POST',
                            url: 'mainclass.php',
                            data: 'APass1=' + encodeURIComponent(APass1) + '&APass2=' + encodeURIComponent(APass2) + '&form=fncAPass1',
                            success: function(data){
                                if(data == 1){
                                    setTimeout(function(){ 
                                        showmodal('alert', "Password successfully set.", '', null, '', null, '0'); 
                                    }, 1000)
                                    $("#mdlAPass").modal("hide");
                                    $(".txtAlterPassAReq").css("border-color", "#b5b5b5");
                                }else{
                                    setTimeout(function(){ 
                                        showmodal('alert', "Password must be atleast 8 characters in length.", '', null, '', null, '1'); 
                                    }, 1000)
                                    $(".txtAlterPassAReq").css("border-color", "#f2a696");
                                }
                            }
                        })
                    }else{
                        setTimeout(function(){ 
                            showmodal('alert', "Password not match.", '', null, '', null, '1'); 
                        }, 1000)
                        $(".txtAlterPassAReq").css("border-color", "#f2a696");
                    }
                }else{
                    setTimeout(function(){ 
                        showmodal('alert', "Please fill all fields.", '', null, '', null, '1'); 
                    }, 1000)
                    $(".txtAlterPassAReq").css("border-color", "#f2a696");
                }
            }

            function fncAPass2(){
                var APass1 = $("#txtAlterAPass3").val();
                var APass2 = $("#txtAlterAPass4").val();
                var APass3 = $("#txtAlterAPass5").val();
                var Count = 0;
                $(".txtAlterPassAReq2").each(function(){
                    if($(this).val() == ""){
                        Count++;
                        $(this).css("border-color", "#f2a696");
                    }else{
                       $(this).css("border-color", "#b5b5b5");
                    }
                })
                if(Count == 0){
                    if(APass2 == APass3){
                        $.ajax({
                            type: 'POST',
                            url: 'mainclass.php',
                            data: 'APass1=' + encodeURIComponent(APass1) + '&APass2=' + encodeURIComponent(APass2) + '&APass3=' + encodeURIComponent(APass3) + '&form=fncAPass2',
                            success: function(data){
                                if(data == 1){
                                    setTimeout(function(){ 
                                        showmodal('alert', "Password successfully updated.", '', null, '', null, '0'); 
                                    }, 1000)
                                    $("#mdlAPass").modal("hide");
                                }else if(data == 2){
                                    setTimeout(function(){ 
                                        showmodal('alert', "Password must be atleast 8 characters in length.", '', null, '', null, '1'); 
                                    }, 1000)
                                    $(".txtAlterPassAReq3").css("border-color", "#f2a696");
                                }else{
                                    setTimeout(function(){ 
                                        showmodal('alert', "Incorrect password.", '', null, '', null, '1'); 
                                    }, 1000)
                                    $("#txtAlterAPass3").css("border-color", "#f2a696");
                                }
                            }
                        })
                    }else{
                        setTimeout(function(){ 
                            showmodal('alert', "Password not match.", '', null, '', null, '1'); 
                        }, 1000)
                        $(".txtAlterPassAReq3").css("border-color", "#f2a696");
                    }
                }else{
                    setTimeout(function(){ 
                        showmodal('alert', "Please fill all fields.", '', null, '', null, '1'); 
                    }, 1000)
                    $(".txtAlterPassAReq2").css("border-color", "#f2a696");
                }
            }
        </script>

        <div class="loadingupdatedb" style="width: 100%; height: 100%; background-color: #000; position: absolute; z-index: 500; top: 0; opacity: 0.6; display: none;"></div>

        <div class="loadingupdatedb" style=" position: absolute; z-index: 600;  left: 35%; top: 30%; display: none;">
            <table>
                <tr>
                    <td><h1 style="color: #FFF;">Updating Database. Please wait . . .</h1></td>
                    <td><img src="assets/images/spinner2.gif" style="width: 100px; height: auto;"></td>
                </tr>
            </table>
        </div>

        <div class="modal fade fade-scale" id="UpdateAuth">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="font-size: 18px;">Confirm Access</h4>
                    </div>
                    <div class="modal-body">
                       <input type="password" class="form-control" style="text-align: center;" id="txtAlterPass">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-success btn-round" onclick="confirmAlterDB();">Confirm</button>
                        <button class="btn btn-sm btn-danger btn-round" onclick='$("#UpdateAuth").modal("hide");'>Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade fade-scale" id="mdlAPass">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="font-size: 18px;">Admin Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group">
                            <label class="col-md-12">Password</label>
                            <div class="col-md-12">
                                <input type="password" class="form-control txtAlterPassAReq" id="txtAlterAPass1">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Confirm Password</label>
                            <div class="col-md-12">
                                <input type="password" class="form-control txtAlterPassAReq" id="txtAlterAPass2">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-success btn-round" onclick="fncAPass1();">Confirm</button>
                        <button class="btn btn-sm btn-danger btn-round" onclick='$("#mdlAPass").modal("hide");'>Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade fade-scale" id="mdlAPass2">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="font-size: 18px;">Change Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group">
                            <label class="col-md-12">Old Password</label>
                            <div class="col-md-12">
                                <input type="password" class="form-control txtAlterPassAReq2" id="txtAlterAPass3">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">New Password</label>
                            <div class="col-md-12">
                                <input type="password" class="form-control txtAlterPassAReq2 txtAlterPassAReq3" id="txtAlterAPass4">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Confirm Password</label>
                            <div class="col-md-12">
                                <input type="password" class="form-control txtAlterPassAReq2 txtAlterPassAReq3" id="txtAlterAPass5">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-success btn-round" onclick="fncAPass2();">Confirm</button>
                        <button class="btn btn-sm btn-danger btn-round" onclick='$("#mdlAPass2").modal("hide");'>Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include('alert_modal/modal.php'); ?>
    </body>
</html>
