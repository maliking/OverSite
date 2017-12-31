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
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary">
  <h5>Add New Event</h5>
</button>
    <!--MODAL AREA!!-->


    <div class="modal modal-primary fade" id="modal-primary">
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
                                    <table id="modal-table" class="table table-striped">
                                        <tr>

                                            <th>Type</th>
                                            <th>For Agent</th>
                                            <th>Due Date</th>
                                            
                                        </tr>

                                        <tr>

                                            <td>
                                                <div class="radio">
                                                    <label>
                      <input type="radio" name="eventType" id="aprv" value="aprv" checked>
                      Aprv
                    </label>
                                                </div>


                                                <div class="radio">
                                                    <label>
                      <input type="radio" name="eventType" id="emd" value="emd" checked>
                      Emd
                    </label>
                                                </div>
                      
                                                <div class="radio">
                                                    <label>
                      <input type="radio" name="eventType" id="disc" value="disc" checked>
                     Disc
                    </label>
                                                </div>
                               
                                                <div class="radio">
                                                    <label>
                      <input type="radio" name="eventType" id="insp" value="insp" checked>
                      Insp
                    </label>
                                                </div>
                         
                                                <div class="radio">
                                                    <label>
                      <input type="radio" name="eventType" id="appr" value="appr" checked>
                      Appr
                    </label>
                                                </div>
                                        
                                                <div class="radio">
                                                    <label>
                      <input type="radio" name="eventType" id="lc" value="lc" checked>
                      LC
                    </label>
                                                </div>
                                
                                                <div class="radio">
                                                    <label>
                      <input type="radio" name="eventType" id="coe" value="coe" checked>
                     Coe
                    </label>
                                                </div>
                                          
                                                <div class="radio">
                                                    <label>
                      <input type="radio" name="eventType" id="other" value="other" >
                                                        <input type="text" placeholder="Other"> 
                    </label>
                                                </div>
                                            </td>
                                            
<!--                                          FOR AGENT-->
                                            <td> 
                                            <div class="radio">
                                                    <label>
                      <input type="radio" name="forAgent" id="johnDoe" value="johnDoe" >
                                                John Doe
                                                </label> 
                                                </div>
                                                 <div class="radio">
                                                <label>
                      <input type="radio" name="forAgent" id="janeSmith" value="janeSmith" >
                                                    Jane Smith
                    </label>
                                                </div>
                                    </td>
<!--                                            END for Agent-->
<!--                                            Select Date-->
                                    <td>
                                               <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
<!--                                        END Select Date-->
                                        </tr>

                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->




                        </div>


                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close
                                </button>
                <button type="button" class="btn btn-outline">Save 
                                </button>
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
  </script>
</body>

</html>
