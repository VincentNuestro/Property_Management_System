<div class="modal fade fade-scale" id="zxoption" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">X & Z Reading</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                	<div class="col-xs-12 col-md-12 well">
                        <div class="row form-group" style="border-bottom: 1px dotted #CCC;">
                            <div class="col-xs-6 col-md-6">
                                <h4 class="green smaller lighter" style="text-align: center;">X Report</h4>
                                <h6 style="font-style: italic;">is a snapshot of what occurred from the beginning of the shift until that point on the register.</h6>
                            </div>
                            <div class="col-xs-6 col-md-6" style="text-align: center;">
                                <div class="col-xs-12 col-md-12" style="margin-bottom: 5px;">
                                    
                                </div>
                                <div class="col-xs-12 col-md-12" style="margin-bottom: 5px;">
                                    <select id="alucard">
                                    </select>
                                </div>
                                <div class="col-xs-12 col-md-12" style="margin-bottom: 5px;">
                                    <button class="btn btn-info btn-xs" onclick="showreportcontainer()">Generate</button>
                                </div>
                            </div>
                        </div>
                		<div class="row form-group">
                            <div class="col-xs-6 col-md-6">
                                <h4 class="green smaller lighter" style="text-align: center;">Z Report</h4>
                                <h6 style="font-style: italic;">is an end of day summary for a register that can only be printed after closing the shift.</h6>
                            </div>
                            <div class="col-xs-4 col-md-4" style="margin-top: 20px;">
                                <button class="btn btn-info btn-xs pull-right" onclick="trapzreading()">Generate</button>
                            </div>
                        </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="xreadingcontainer" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
                <div class="row form-group" style="margin: 13px;">
                    <div class="row form-group">
                        <div class="row form-group" style="border-top: 5px solid;border-bottom: 5px solid;margin: 2px;">
                            <div>
                                <h4 class="smaller lighter" style="font-weight: bold;text-align: center;" id="xcompanyname"></h4>
                            </div>
                            <div style="margin-top: -10px;">
                                <label style="text-align: center;" id="xaddress"></label>
                            </div>
                            <div style="margin-top: -10px;">
                                <center><label >TIN :&nbsp;</label><label id="xtin"></label></center>
                                </div>
                            <div style="margin-top: -10px;">
                                <center id="machinenumberdito"></center>
                            </div>
                            <div style="margin-top: -10px;">
                                <center>Telephone :&nbsp;<label id="xtele"></label></center>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: -25px;">
                        <center>
                        <h4 class="smaller lighter" style="font-weight: bold;">X Report</h4>
                            <table style="margin-left: 5px;margin-top: -10px;">
                                <tbody>
                                    <tr>
                                        <td><label id="datetimedito"></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
    				<div class="row form-group">
        				<div class="row form-group" style="border-top: 5px solid;margin: 2px;">
        				</div>
    				</div>
                    <div class="row" style="margin-top: -15px;">
                        <table style="margin-left: 5px;">
                            <thead style="margin-bottom: 10px;">
                                <th width="200" align="left">Description</th>
                                <th width="200" align="right">Value</th>
                            </thead>
                            <tbody id="tbodyreport">
                                <tr>
                                    <td height="5"></td>
                                </tr>
                                <tr>
                                    <td><strong>Gross Sales</strong></td>
                                    <td align="right"><label id="grosssalesdito"></label></td>
                                </tr>
                                <tr>
                                    <td><strong>Net Sales</strong></td>
                                    <td align="right"><label id="netsalesdito"></label></td>
                                </tr>
                                <tr>
                                    <td><strong>Daily Sales</strong></td>
                                    <td align="right"><label id="dailysalesdito"></label></td>
                                </tr>
                                <tr>
                                    <td height="20"></td>
                                </tr>
                                <tr>
                                    <td><strong>Cash</strong></td>
                                    <td align="right"><label id="cashsales"></label></td>
                                </tr>
                                <tr>
                                    <td><strong>Card</strong></td>
                                    <td align="right"><label id="cardsales"></label></td>
                                </tr>
                                <tbody id="carddistinct"></tbody>
                                <tr>
                                    <td><strong>Check</strong></td>
                                    <td align="right"><label id="checksales"></label></td>
                                </tr>
                                <tbody id="checkdistinct"></tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="row form-group">
                        <div class="row form-group" style="border-top: 5px solid;margin: 2px;">
                        </div>
                    </div>
                     <div class="row" style="margin-top: -15px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="font-weight: bold;">Initiated by:&nbsp;<label id="userdito"></label></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Signature:&nbsp;___________________________</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right" style="margin-top: 10px;">
                        <button class="btn btn-success btn-sm" onclick="showprintofx()">Print</button>
                    </div>
    			</div>
            </div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="zreadingcontainer" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row form-group" style="margin: 13px;">
                    <div class="row form-group">
                        <div class="row form-group" style="border-top: 5px solid;border-bottom: 5px solid;margin: 2px;">
                            <div>
                                <h4 class="smaller lighter" style="font-weight: bold;text-align: center;" id="xcompanyname2"></h4>
                            </div>
                            <div style="margin-top: -10px;">
                                <label style="text-align: center;" id="xaddress2"></label>
                            </div>
                            <div style="margin-top: -10px;">
                                <center><label >TIN :&nbsp;</label><label id="xtin2"></label></center>
                                </div>
                            <div style="margin-top: -10px;">
                                <center id="machinenumberdito2"></center>
                            </div>
                            <div style="margin-top: -10px;">
                                <center>Telephone :&nbsp;<label id="xtele2"></label></center>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: -25px;">
                        <center>
                        <h4 class="smaller lighter" style="font-weight: bold;">Z Report</h4>
                            <table style="margin-left: 5px;margin-top: -10px;">
                                <tbody>
                                    <tr>
                                        <td><label id="datetimedito2"></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="row form-group">
                        <div class="row form-group" style="border-top: 5px solid;margin: 2px;">
                        </div>
                    </div>
                    <div class="row" style="margin-top: -15px;">
                        <table style="margin-left: 5px;">
                            <thead style="margin-bottom: 10px;">
                                <th width="200" align="left">Description</th>
                                <th width="200" align="right">Value</th>
                            </thead>
                            <tbody id="tbodyreport">
                                <tr>
                                    <td height="5"></td>
                                </tr>
                                <tr>
                                    <td><strong>Gross Sales</strong></td>
                                    <td align="right"><label id="grosssalesdito2"></label></td>
                                </tr>
                                <tr>
                                    <td><strong>Net Sales</strong></td>
                                    <td align="right"><label id="netsalesdito"></label></td>
                                </tr>
                                <tr>
                                    <td><strong>Daily Sales</strong></td>
                                    <td align="right"><label id="dailysalesdito2"></label></td>
                                </tr>
                                <tr>
                                    <td height="20"></td>
                                </tr>
                                <tr>
                                    <td><strong>Cash</strong></td>
                                    <td align="right"><label id="cashsales2"></label></td>
                                </tr>
                                <tr>
                                    <td><strong>Card</strong></td>
                                    <td align="right"><label id="cardsales2"></label></td>
                                </tr>
                                <tbody id="carddistinct2"></tbody>
                                <tr>
                                    <td><strong>Check</strong></td>
                                    <td align="right"><label id="checksales2"></label></td>
                                </tr>
                                <tbody id="checkdistinct2"></tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="row form-group">
                        <div class="row form-group" style="border-top: 5px solid;margin: 2px;">
                        </div>
                    </div>
                     <div class="row" style="margin-top: -15px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="font-weight: bold;">Initiated by:&nbsp;<label id="userdito2"></label></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Signature:&nbsp;___________________________</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right" style="margin-top: 10px;">
                        <button class="btn btn-success btn-sm" onclick="showprintofz()">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    <div id="xreading">
        <div class="row form-group" style="margin: 13px;">
            <div class="row form-group">
                <div class="row form-group" style="border-top: 5px solid;border-bottom: 5px solid;margin: 2px;">
                    <div style="margin-top: -25px;">
                        <h4 class="smaller lighter" style="font-weight: bold;text-align: center;font-size: 18px;" id="xcompanyname3"></h4>
                    </div>
                    <div style="margin-top: -25px;">
                        <center><label id="xaddress3"></label></center>
                    </div>
                    <div>
                        <center><label >TIN :&nbsp;</label><label id="xtin3"></label></center>
                        </div>
                    <div>
                        <center id="machinenumberdito3"></center>
                    </div>
                    <div>
                        <center>Telephone :&nbsp;<label id="xtele3"></label></center>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: -20px;">
                <center>
                <h4 class="smaller lighter" style="font-weight: bold;">X Report</h4>
                    <table style="margin-top: -15px;">
                        <tbody>
                            <tr>
                                <td><center><label id="datetimedito3"></label></center></td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>
            <div class="row form-group">
                <div class="row form-group" style="border-top: 5px solid;margin: 2px;">
                </div>
            </div>
            <center>
            <div class="row">
                <table style="margin-left: 5px;">
                    <thead style="margin-bottom: 10px;">
                        <th width="200" align="left">Description</th>
                        <th width="200" align="right">Value</th>
                    </thead>
                    <tbody id="tbodyreport3">
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <tr>
                            <td><strong>Gross Sales</strong></td>
                            <td align="right"><label id="grosssalesdito3"></label></td>
                        </tr>
                        <tr>
                            <td><strong>Net Sales</strong></td>
                            <td align="right"><label id="netsalesdito3"></label></td>
                        </tr>
                        <tr>
                            <td><strong>Daily Sales</strong></td>
                            <td align="right"><label id="dailysalesdito3"></label></td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                        </tr>
                        <tr>
                            <td><strong>Cash</strong></td>
                            <td align="right"><label id="cashsales3"></label></td>
                        </tr>
                        <tr>
                            <td><strong>Card</strong></td>
                            <td align="right"><label id="cardsales3"></label></td>
                        </tr>
                        <tbody id="carddistinct3"></tbody>
                        <tr>
                            <td><strong>Check</strong></td>
                            <td align="right"><label id="checksales3"></label></td>
                        </tr>
                        <tbody id="checkdistinct3"></tbody>
                    </tbody>
                </table>
            </div>
            <div class="row form-group">
                <div class="row form-group" style="border-top: 5px solid;margin: 2px;">
                </div>
            </div>
             <div class="row">
                <table>
                    <tbody>
                        <tr>
                            <td style="font-weight: bold;">Initiated by:&nbsp;<label id="userdito3"></label></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Signature:&nbsp;___________________________</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </center>
        </div>
    </div>
</div>

<div style="display: none;">
    <div id="zreading">
        <div class="row form-group" style="margin: 13px;">
            <div class="row form-group">
                <div class="row form-group" style="border-top: 5px solid;border-bottom: 5px solid;margin: 2px;">
                    <div style="margin-top: -25px;">
                        <h4 class="smaller lighter" style="font-weight: bold;text-align: center;font-size: 18px;" id="xcompanyname4"></h4>
                    </div>
                    <div style="margin-top: -25px;">
                        <center><label id="xaddress4"></label></center>
                    </div>
                    <div>
                        <center><label >TIN :&nbsp;</label><label id="xtin4"></label></center>
                        </div>
                    <div>
                        <center id="machinenumberdito4"></center>
                    </div>
                    <div>
                        <center>Telephone :&nbsp;<label id="xtele4"></label></center>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: -20px;">
                <center>
                <h4 class="smaller lighter" style="font-weight: bold;">Z Report</h4>
                    <table style="margin-top: -15px;">
                        <tbody>
                            <tr>
                                <td><center><label id="datetimedito4"></label></center></td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>
            <div class="row form-group">
                <div class="row form-group" style="border-top: 5px solid;margin: 2px;">
                </div>
            </div>
            <center>
            <div class="row">
                <table style="margin-left: 5px;">
                    <thead style="margin-bottom: 10px;">
                        <th width="200" align="left">Description</th>
                        <th width="200" align="right">Value</th>
                    </thead>
                    <tbody id="tbodyreport4">
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <tr>
                            <td><strong>Gross Sales</strong></td>
                            <td align="right"><label id="grosssalesdito4"></label></td>
                        </tr>
                        <tr>
                            <td><strong>Net Sales</strong></td>
                            <td align="right"><label id="netsalesdito4"></label></td>
                        </tr>
                        <tr>
                            <td><strong>Daily Sales</strong></td>
                            <td align="right"><label id="dailysalesdito4"></label></td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                        </tr>
                        <tr>
                            <td><strong>Cash</strong></td>
                            <td align="right"><label id="cashsales4"></label></td>
                        </tr>
                        <tr>
                            <td><strong>Card</strong></td>
                            <td align="right"><label id="cardsales4"></label></td>
                        </tr>
                        <tbody id="carddistinct4"></tbody>
                        <tr>
                            <td><strong>Check</strong></td>
                            <td align="right"><label id="checksales4"></label></td>
                        </tr>
                        <tbody id="checkdistinct4"></tbody>
                    </tbody>
                </table>
            </div>
            <div class="row form-group">
                <div class="row form-group" style="border-top: 5px solid;margin: 2px;">
                </div>
            </div>
             <div class="row">
                <table>
                    <tbody>
                        <tr>
                            <td style="font-weight: bold;">Initiated by:&nbsp;<label id="userdito4"></label></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Signature:&nbsp;___________________________</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </center>
        </div>
    </div>
</div>

<input type="hidden" id="cookienginamo">
<input type="hidden" id="cookiengamamo">
<?php 
include ("zxreading/script.php");
?>