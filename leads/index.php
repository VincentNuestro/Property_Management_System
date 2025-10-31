<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-3">
            <h1 style="font-weight: bold;">INQUIRY</h1>
            <!-- <h6 style="color:#2679B5;">&nbsp;&nbsp;&nbsp;<label id="txtpageheader"></label></h6> -->
        </div>
        <div class="col-md-9">
            <div class="row form-group" style="margin-right: 1px;">
                <!-- <span class='label label-xlg label-danger arrowed-in-right arrowed pull-right bold'>Cancelled / Junked</span> -->
                <span class='label label-xlg label-warning arrowed-in-right arrowed pull-right bold'>Occupied</span>
                <span class='label label-xlg label-success arrowed-in-right arrowed pull-right bold'>Confirmed</span>
                <span class='label label-xlg label-info arrowed-in-right arrowed pull-right bold'>Approved Application</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-yellow'>For Approval</span>
                <span class='label label-xlg label-pink arrowed-in-right arrowed pull-right bold'>Pending Application</span>
                <span class='label label-xlg label-inverse arrowed-in-right arrowed pull-right bold'>Inquired</span>
                <?php if($_REQUEST['type'] != 'proposal' && $_REQUEST['type'] != 'inquiry'){ ?><span class='label label-xlg label-purple arrowed-in-right arrowed pull-right bold'>Lead</span><?php } ?>
            </div>
        </div>
    </div>
</div>

<?php  
    if($_REQUEST['type'] == 'prospects'){
        include "leads/prospects/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Prospects'); }) </script>";
    }else if($_REQUEST['type'] == "awareness"){
    include "leads/subleads/index.php";
    echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Awareness'); $('.lblGenTitle').text('Awareness Information'); $('#LeadsGenButtonAwareness').css('display', 'block'); $('#LeadsGenButtonReferral').css('display', 'none'); $('#LeadsGenButtonDemo').css('display', 'none'); $('#LeadsGenButtonProposal').css('display', 'none'); $('#LeadsGenButtonClosingMeeting').css('display', 'none'); $('#LeadsGenButtonContracSigning').css('display', 'none'); }) </script>";
    }else if($_REQUEST['type'] == "referral"){
        include "leads/subleads/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Refferal'); $('.lblGenTitle').text('Referral Information'); $('#LeadsGenButtonAwareness').css('display', 'none'); $('#LeadsGenButtonReferral').css('display', 'block'); $('#LeadsGenButtonDemo').css('display', 'none'); $('#LeadsGenButtonProposal').css('display', 'none'); $('#LeadsGenButtonClosingMeeting').css('display', 'none'); $('#LeadsGenButtonContracSigning').css('display', 'none'); }) </script>";
    }else if($_REQUEST['type'] == "demo"){
        include "leads/subleads/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Demo'); $('.lblGenTitle').text('Demo Information'); $('#LeadsGenButtonAwareness').css('display', 'none'); $('#LeadsGenButtonReferral').css('display', 'none'); $('#LeadsGenButtonDemo').css('display', 'block'); $('#LeadsGenButtonProposal').css('display', 'none'); $('#LeadsGenButtonClosingMeeting').css('display', 'none'); $('#LeadsGenButtonContracSigning').css('display', 'none'); }) </script>";
    }else if($_REQUEST['type'] == "closingmeeting"){
        include "leads/subleads/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Closing Meeting'); $('.lblGenTitle').text('Closing Meeting Information'); $('#LeadsGenButtonAwareness').css('display', 'none'); $('#LeadsGenButtonReferral').css('display', 'none'); $('#LeadsGenButtonDemo').css('display', 'none'); $('#LeadsGenButtonProposal').css('display', 'none'); $('#LeadsGenButtonClosingMeeting').css('display', 'block'); $('#LeadsGenButtonContracSigning').css('display', 'none'); }) </script>";
    }else if($_REQUEST['type'] == "contractsigning"){
        include "leads/subleads/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Contract Signing'); $('.lblGenTitle').text('Contract Signing Information'); $('#LeadsGenButtonAwareness').css('display', 'none'); $('#LeadsGenButtonReferral').css('display', 'none'); $('#LeadsGenButtonDemo').css('display', 'none'); $('#LeadsGenButtonProposal').css('display', 'none'); $('#LeadsGenButtonClosingMeeting').css('display', 'none'); $('#LeadsGenButtonContracSigning').css('display', 'block'); }) </script>";
    }else if($_REQUEST['type'] == 'proposal'){
        include "leads/proposal/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Proposal'); }) </script>";
    }else if($_REQUEST['type'] == 'inquiry'){
        include "leads/inquiry/index.php";
        echo "<script type='text/javascript'> $(function(){ $('#txtpageheader').text('List of Inquiry'); }) </script>";
    }
?>