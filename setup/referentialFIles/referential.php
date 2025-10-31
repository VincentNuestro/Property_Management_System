<div class="row">
	<div class="col-md-12">
		<div class="row form-group">
			<div class="col-md-2">
                <div class="search-area well well-sm">
                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-users light-green bigger-130"></i>&nbsp; Tenant
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <ol class="dd-list">
                        <?php if(SysLeaseSetup('isClassification') == "1"){ ?>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Classification');">
                            <div class="dd2-content" style="<?php if(SysLeaseSetup('isClassification') == "1"){ ?> background-color: rgb(102, 102, 102); color: rgb(255, 255, 255); <?php } ?>" id="ddClassification">
                                <label>Classification</label>
                            </div>
                        </li>
                        <?php } ?>
                        <?php if(SysLeaseSetup('isDepartment') == "1"){ ?>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Department'); selectedClassification();">
                            <div class="dd2-content" style="<?php if(SysLeaseSetup('isClassification') == "0" && SysLeaseSetup('isDepartment') == "1"){ ?> background-color: rgb(102, 102, 102); color: rgb(255, 255, 255); <?php } ?>" id="ddDepartment">
                                <label>Department</label>
                            </div>
                        </li>
                        <?php } ?>
                        <?php if(SysLeaseSetup('isCategory') == "1"){ ?>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Category'); selectedUnitDept();">
                            <div class="dd2-content" style="<?php if(SysLeaseSetup('isClassification') == "0" && SysLeaseSetup('isDepartment') == "0" && SysLeaseSetup('isCategory') == "1"){ ?> background-color: rgb(102, 102, 102); color: rgb(255, 255, 255); <?php } ?>" id="ddCategory">
                                <label>Category</label>
                            </div>
                        </li>
                        <?php } ?>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Industry'); $('#txtPageIndustry').val('1'); displayIndustry();">
                            <div class="dd2-content" id="ddIndustry">
                                <label>Industry</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Requirements'); $('#txtPageRequirements').val('1'); displayReq();">
                            <div class="dd2-content" id="ddRequirements">
                                <label>Requirements</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Permits'); $('#txtPagePermits').val('1'); displayListofTypes();">
                            <div class="dd2-content" id="ddPermits">
                                <label>Permits</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Source'); $('#txtPageSource').val('1'); displayListofSource();">
                            <div class="dd2-content" id="ddSource">
                                <label>Source</label>
                            </div>
                        </li>
                    </ol>
                    <div class="space-4"></div>

                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-wrench light-green bigger-130"></i>&nbsp; Maintenance
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <ol class="dd-list">
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('MainCategory'); $('#txtPageMainCat').val('1'); displayMainCat();">
                            <div class="dd2-content" id="ddMainCategory">
                                <label>Category</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('MainTask'); $('#txtPageMainTask').val('1'); displaySetTask();">
                            <div class="dd2-content" id="ddMainTask">
                                <label>Task</label>
                            </div>
                        </li>
                    </ol>
                    <div class="space-4"></div>

                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-calendar-check-o light-green bigger-130"></i>&nbsp; Events
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <ol class="dd-list">
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Facilities'); $('#txtPageFacilities').val('1'); fncFacilitiesList();"> 
                            <div class="dd2-content" id="ddFacilities">
                                <label>Services & Facilities</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Soundnper'); $('#txtPageSoundnper').val('1'); fncSoundnperList();">
                            <div class="dd2-content" id="ddSoundnper">
                                <label>Sound System & Personnel</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Manpower'); $('#txtPageManpower').val('1'); fncManpowerList();">
                            <div class="dd2-content" id="ddManpower">
                                <label>Manpower</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Organizerm'); $('#txtPageOrganizerm').val('1'); fncOrganizermList();">
                            <div class="dd2-content" id="ddOrganizerm">
                                <label>Organizer Materials</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Promotionalp'); $('#txtPagePromotionalp').val('1'); fncPromotionalpList();">
                            <div class="dd2-content" id="ddPromotionalp">
                                <label>Promotional Paraphernalias</label>
                            </div>
                        </li>
                    </ol>
                    <div class="space-4"></div>

                    <div class="search-filter-header bg-primary">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-ellipsis-h light-green bigger-130"></i>&nbsp; Other
                        </h5>
                    </div>
                    <div class="space-4"></div>
                    <ol class="dd-list">
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('HouseRules'); $('#txtPageHouseRules').val('1'); showmainHouseRules();">
                            <div class="dd2-content" id="ddHouseRules">
                                <label>House Rules</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('RequestCategory'); $('#txtPageRequestCategory').val('1'); displayRequestCategory();">
                            <div class="dd2-content" id="ddRequestCategory">
                                <label>Request Category</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('RequestTags'); $('#txtPageRequestTags').val('1'); displayRequestTags(); showRequestCategory();">
                            <div class="dd2-content" id="ddRequestTags">
                             <label>Request Tags</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Charges'); $('#txtPageCharges').val('1'); showRefCharges();">
                            <div class="dd2-content" id="ddCharges">
                                <label>Charges</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Penalty'); $('#txtPagePenalty').val('1'); fncPenaltyList();">
                            <div class="dd2-content" id="ddPenalty">
                                <label>Penalty</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Bank'); $('#txtPageBank').val('1'); displayBank();">
                            <div class="dd2-content" id="ddBank">
                                <label>Bank</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('PaymentType'); $('#txtPagePaymentType').val('1'); displayPaymentType();">
                            <div class="dd2-content" id="ddPaymentType">
                                <label>Payment Type</label>
                            </div>
                        </li>
                    </ol>
                    <div class="space-4"></div>

                    <div class="search-filter-header bg-primary hide">
                        <h5 class="smaller no-margin-bottom">
                            <i class="ace-icon fa fa-user light-green bigger-130"></i>&nbsp; Employee
                        </h5>
                    </div>
                    <div class="space-4 hide"></div>
                    <ol class="dd-list hide">
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('EmpDepartment'); $('#txtPageMainDepartment').val('1'); showmainDepartment();">
                            <div class="dd2-content" id="ddEmpDepartment">
                                <label>Department</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Position'); $('#txtPagePosition').val('1'); displayPosition(); showDepartment();">
                            <div class="dd2-content" id="ddPosition">
                                <label>Position</label>
                            </div>
                        </li>
                        <li class="dd-item dd2-item" style="cursor: pointer;" onclick="fncChangeRef('Employee'); $('#txtPageEmployee').val('1'); displayEmployee(); showEmpDepartment(); showEmpPosition(); showtxtmall();">
                            <div class="dd2-content" id="ddEmployee">
                                <label>Employee</label>
                            </div>
                        </li>
                    </ol>
                    <div class="space-4"></div>
                </div>
			</div>
			<?php
				include('unit_classification/index.php');
				include('unit_department/index.php');
				include('unit_category/index.php');
				include('unit_industry/index.php');
				include('main_cat/index.php');
				include('main_setTask/index.php');
				include('main_HouseRules/index.php');
				include('unit_bank/index.php');
				include('main_Department/index.php');
				include('unit_position/index.php');
				include('unit_req/index.php');
				include('oth_Permits/index.php');
				include('em_Employee/index.php');
				include('other_RefCharges/index.php');
				include('oth_Penalty/index.php');
				include('request_category/index.php');
				include('request_tags/index.php');
                include('events_facilities/index.php');
                include('events_soundnper/index.php');
                include('events_manpower/index.php');
                include('events_organizerm/index.php');
                include('events_promotionalp/index.php');
                include('oth_payment/index.php');
                include('oth_source/index.php');
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
	setTimeout(function(){
    	$(".fixTable").tableHeadFixer();
    	$(".ThisIsForCodes").on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z!@#$%^*()0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        	if (!regex.test(key)) {
       			event.preventDefault();
       			return false;
    		}
     	});
	}, 1000)

	function fncChangeRef(ref){
        $(".divReferential").addClass("hide");
        $(".ref"+ref).removeClass("hide");
		$(".dd2-content").css("background-color", "rgb(248, 250, 255)");
		$(".dd2-content").css("color", "rgb(124, 158, 178)");
		$("#dd"+ref).css("background-color", "rgb(102, 102, 102)");
		$("#dd"+ref).css("color", "rgb(255, 255, 255)");
	}

	// <!-- referentialreportsruth -->
	function getheaderprint(mallid,classN,condition){
		var cond = JSON.parse( condition ).join('&');
		var toprint = "";
		$.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'mallID=' + mallid + '&form=getheaderprint',
            success:function(data){
                $("#printable_divtemplate").html(data);
                // toprint = $("#printable_div_header_container").html();
            }, complete: function(){
            	$.ajax({
            		type: 'POST',
		            url: 'mainclass.php',
		            data: cond + '&form='+classN,
		            success:function(data){
		            	 $("#printable_div_content").html(data);
		                toprint = $("#printable_div").html();	
		            	var myheight = $(window).height()-40;
		                var mywidth = $(window).width()-40;
		                var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
		                popupWin.document.open();
		                popupWin.document.write("<html><head><link rel='stylesheet' href='assets/css/bootstrap.min.css' /><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
		                popupWin.document.close();
		            }
                })
            }
        })
	}
	// <!-- referentialreportsruth -->
</script>