<!DOCTYPE html>
<html>

<head>
    <title> </title> 
    <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
</head>

<body>
    <style>
        #modal-table {
            color: black;
        }

    </style>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
  <h5>Add New Date</h5>
</button>
    <!--MODAL AREA!!-->


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
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->




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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

    <!-- /.modal -->
    <div class="container">

        <!--MODAL AREA-->

    </div>
<!-- bootstrap datepicker -->
<script src="../../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <!--                    END example modal-->
    <script>
           //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
            $('#iconified').on('keyup', function() {
    var input = $(this);
    if(input.val().length === 0) {
        input.addClass('empty');
    } else {
        input.removeClass('empty');
    }
});
  </script>
</body>

</html>
