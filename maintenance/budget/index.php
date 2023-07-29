<div class="row">
    <div class="row form-group">
        <div class="col-xs-3 col-sm-3 col-lg-3">
            <div class="row form-group">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="search-area well well-sm">
                        <div class="search-filter-header bg-primary">
                            <h5 class="smaller no-margin-bottom">
                                <i class="ace-icon fa fa-sliders light-green bigger-130"></i>
                            </h5>
                        </div>
                        <!-- ADDED Ronaldo 2018-10-11 -->
                        <div class="space-10"></div>
                        <div>
                            <p style="margin-bottom: 4px; margin-left: 2px;font-size: 18px;">Select <label class="txtSysBuilding" style="margin-bottom: 4px; margin-left: 2px;font-size: 18px;"></label></p>
                            <select class="form-control" id="selMall" onchange="tblbudget()"></select>
                        </div>
                        <!-- END ADDED Ronaldo 2018-10-11 -->
                        <div class="space-10"></div>
                        <div>
                            <p style="margin-bottom: 4px; margin-left: 2px;font-size: 18px;">Select Year</p>
                            <select class="form-control" id="budgetyear" onchange="">
                                <option value="">-- Select Year --</option>
                                <?php
                                    for($a = 5; $a >= 1; $a--){
                                        $timestamp = strtotime('-'. $a .' years');
                                        $forval1 = date('Y', $timestamp);
                                        ?>
                                            <option value="<?php echo $forval1; ?>"><?php echo $forval1; ?></option>
                                        <?php
                                    }
                                    ?>
                                        <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                                    <?php                       
                                    for($b = 1; $b <= 5; $b++){
                                        $timestamp2 = strtotime('+'. $b .' years');
                                        $forval2 = date('Y', $timestamp2);
                                        ?>
                                            <option value="<?php echo $forval2; ?>"><?php echo $forval2; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <div class="space-10"></div>
                            <p style="margin-bottom: 4px; margin-left: 2px;font-size: 18px;">Select Utilities</p>
                            <select class="form-control" id="typeofbudget" onclick="tblbudget();"></select>
                            <div class="space-10"></div>
                            <button class="btn btn-sm btn-primary btn-block hide isadmin select-addmaintenancebudget btn-round" onclick="addbudgetperyear();">Add/Update Budget</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-9 col-md-9 col-lg-9">
            <div class="row">
                <div class="parent">
                    <table class="table table-bordered fixTable">
                        <tr>
                            <th>Category</th>
                            <th>Year</th>
                            <th>January</th>
                            <th>February</th>
                            <th>March</th>
                            <th>April</th>
                            <th>May</th>
                            <th>June</th>
                            <th>July</th>
                            <th>August</th>
                            <th>September</th>
                            <th>October</th>
                            <th>November</th>
                            <th>December</th>
                        </tr>
                        <tbody id="tblbudget"></tbody>
                    </table>
                </div>
                <table class="tabledash_footer table" style="margin: 0px !important;">
                    <thead>
                        <tr>
                            <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                <font id="txtcomplaintsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                <input id="txt_userpage" type="hidden">
                                <ul id="ulpaginationcomplaint" class="pagination pull-right"></ul>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div> 
        </div>
    </div>
</div>

<!-- MODAL FOR ADDING BUDGET PER YEAR -->
<div class="modal fade fade-scale" id="modalforaddingbudget" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="labelformodalofaddingbudget">Budget</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="col-xs-6 col-md-6 col-lg-6">
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    January
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xjan">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    February
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xfeb">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    March
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xmar">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    April
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xapr">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    May
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xmay">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    June
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xjun">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6">
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    July
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xjul">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    August
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xaug">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    September
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xsep">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    October
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xoct">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    November
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xnov">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    December
                                </div>
                                <div class="col-xs-8 col-md-8 col-lg-8">
                                    <input type="text" class="form-control" id="xdec">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: -30px;">
                <button class="btn btn-primary btn-sm btn-round" id="nilalamanngpusobtn" onclick='savebudgetperyear()'><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>
<?php include("script.php"); ?>