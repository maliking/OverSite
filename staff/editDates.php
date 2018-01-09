<!DOCTYPE html>
<html>

<head>
    <title> </title> 
</head>
     <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<body>
    <style>
        .modal-body {
            color: black;
        }
        #modal-table {
            color: black;
            text-align: left;
        }
        th, td {
            padding-right: 40px;
        }

    </style>

    <!-- Button trigger modal -->
    <button type="button"  data-toggle="modal" data-target="#editDatemodal">
  <i class="fa fa-edit"></i>
</button>
    <!--MODAL AREA!!-->


    <div class="modal fade" id="editDatemodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   1204 Rogers Ct. Salinas, CA 94934
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
        <div class="modal-body">
                        
                       
                            
                                    <form >
                                    <table id="modal-table" >
                                        <tr>

                                        <th>Type</th>
                                        <th>Current Date</th>
                                        <th>New Date</th>
                                            
                                        </tr>

                                        <tr>
                                            <td>Aprv</td>
                                            <td>3/1/17</td>
                                            <td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td>
                                        </tr>
                                         <tr>
                                            <td>EMD</td>
                                              <td>3/1/17</td>
                                            <td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td>
                                        </tr>
                                           <tr>
                                            <td>DISC</td>
                                                <td>3/1/17</td>
                                            <td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td>
                                        </tr>
                                           <tr>
                                            <td>INSP</td>
                                                <td>3/1/17</td>
                                            <td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td>
                                        </tr>
                                           <tr>
                                            <td>APPR</td>
                                                <td>3/1/17</td>
                                            <td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td>
                                        </tr>
                                           <tr>
                                            <td>LC</td>
                                                <td>3/1/17</td>
                                            <td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td>
                                        </tr>
                                           <tr>
                                            <td>COE</td>
                                                <td>3/1/17</td>
                                            <td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td>
                                        </tr>
                     

                                
                                      

                                    </table>
                                    </form>  
                      




                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                                </button>
                <button type="button" class="btn btn-default">Save
                                </button>
            </div>
                              </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->

            
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

    <!-- /.modal -->
    <div class="container">

        <!--MODAL AREA-->

    </div>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>

</body>

</html>
