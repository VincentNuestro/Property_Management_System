<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-3 col-xs-12">
            <h1 style="font-weight: bold;">System Setup</h1>
            <h6 style="color:#2679B5;">&nbsp;&nbsp;&nbsp;<label id="txtpageheader"></label></h6>
        </div>
        <div class="col-md-9 col-xs-12 isUAC">
            <span class="label label-xlg label-danger arrowed-in-right arrowed pull-right">Inactive</span>
            <span class="label label-xlg label-success arrowed-in-right arrowed pull-right">Active</span>
        </div>
        <div class="col-md-9 col-xs-12 isTAC">
            <span class="label label-xlg label-danger arrowed-in-right arrowed pull-right">Inactive</span>
            <span class="label label-xlg label-success arrowed-in-right arrowed pull-right">Active</span>
        </div>
    </div>
</div>
<?php 
  $systype = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup", $connection));
    if($_GET['type'] == 'referential'){
        include "setup/referentialFIles/referential.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Referential'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
    }else if($_GET['type'] == 'mallconfig'){
        include "setup/mall_configuration/mall-conf.php";
        if($systype[0] == "0"){
            echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Mall Configuration'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
        }else if($systype[0] == "1"){
            echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Building Configuration'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
        }else if($systype[0] == "2"){
            echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Building Configuration'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
        }else if($systype[0] == "3"){
            echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Palengke Configuration'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
        }else if($systype[0] == "4"){
            echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Cemetery Configuration'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
        }
    }else if($_GET['type'] == 'termsandconditions'){
        include "setup/termsandcondition/termsandcondition.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Terms and Conditions'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'block'); }) </script>";
    }else if($_GET['type'] == 'userandaccess'){
        include "setup/user/user.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('User and Accessibility'); $('.isUAC').css('display', 'block'); $('.isTAC').css('display', 'none'); }) </script>";
    }else if($_GET['type'] == 'companylist'){
        include "setup/profiles/company_list.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Company List'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
    }else if($_GET['type'] == 'maintenancechecklist'){
        include "setup/maintenance/setup.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Maintenance Checklist'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
    }else if($_GET['type'] == 'syssetup'){
        if($_SESSION['MMS-UserID'] == 'GatessoftCorp' || $_SESSION['MMS-UserID'] == 'Superuser'){
            include "setup/systemsetup/index.php";
            echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Maintenance Checklist'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
        }
    }else if($_GET['type'] == 'zaputility'){
        include "setup/zaputility/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Zap Utility'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
    }else if($_GET['type'] == 'reporttemplates'){
        include "setup/contract/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Report Templates'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
    }else if($_GET['type'] == 'jdamapping'){
        include "setup/jdamapping/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('JDA Mapping - Integration Requirements'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
    }else if($_GET['type'] == 'reftenantspayment'){
        include "setup/tenantspaymentx/tenantspayment.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('Beginning Balances of Tenant\'s Deposits/Payments'); $('.isUAC').css('display', 'none'); $('.isTAC').css('display', 'none'); }) </script>";
    }
?>