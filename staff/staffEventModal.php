<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel">Add a New Date</h3>
            </div>
            <div class="modal-body">

                <!-- content goes here -->
                <form>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <select class="form-control" id="address">
                            <option>1234 House St.</option>
                            <option>492 Example Dr.</option>
                        </select>
                        <br>
                        <label for="agent">Agent:</label>
                        <select class="form-control" id="agent">
                            <option>John Doe</option>
                            <option>Jane Smith</option>
                        </select>
                        <br>
                        <label for="radio">Date Type: </label>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Acc. - Accepted</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">EMD - Earnest Money Deposit</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Seller Disclosure</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Inspection</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Appr. - Appraisal</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">LC - Loan Contingences</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">COE - Close of Escrow</label>
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" role="button" id="resetButton" class="btn btn-success btn-block" data-dismiss="modal" >Submit</button>
            </div>
        </div>
    </div>
</div>
<!--
<div class="modal modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">

                    <div class="row">
                        <div class="box">

                            <div class="box-body no-padding">

                                <form>
                                    <label for="address"> Address</label>  <select id="address">
                                        <option value="">1234 House st</option>
                                        <option value="">5678 App Lane</option>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="agent">Agent</label> <select id="agent">
                                        <option value="">John Doe</option>
                                        <option value="">Jane Smith</option>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="type">Type</label> <select id="type">
                                        <option value="">APRV</option>
                                        <option value="">EMD</option>
                                        <option value="">DISC</option>
                                        <option value="">INSP</option>
                                        <option value="">APPR</option>
                                        <option value="">LC</option>
                                        <option value="">COE</option>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="datepicker">Date</label>
                                    <input type="text"  class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                                    <br>
                                    <br>
                                </form>
                            </div>
                             /.box-body 
                        </div>
                         /.box 




                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-default">Save 
                    </button>
                </div>
            </div>
        </div>
    </div>
     /.modal-content 
</div>
 /.modal-dialog -->
