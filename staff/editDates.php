<!DOCTYPE html>
<html>
<head>
    <title> </title> 
</head>
     <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

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
        input.empty {
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
}

    </style>

    <!-- Button trigger modal -->
    <button type="button"  data-toggle="modal" <?php echo "data-target=#editDatemodal".$count;?>>
  <i class="fa fa-edit"></i>
</button>
    <!--MODAL AREA!!-->


    <div class="modal fade" <?php echo "id=editDatemodal" . $count;?>>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <?php echo $trans['address']; ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
        <div class="modal-body">
                        
                       
                            
                                    <form>
                                    <table id="modal-table" >
                                        <tr>
                                        <th>Type</th>
                                        <th>Current Date</th>
                                        <th>New Date</th>
                                        </tr>
                                        <tr><td>Aprv</td><?php echo "<td>" . date('m/d/y', strtotime($day)) . "</td>"; ?> <td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td> </tr>
                                         <tr><td>EMD</td><?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['emdDays'] . ' days')) . "</td>"; ?><td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td></tr>
                                           <tr><td>DISC</td><?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['sellerDiscDays'] . ' days')) . "</td>"; ?><td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td> </tr>
                                        <tr><td>INSP</td><?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['genInspecDays'] . ' days')) . "</td>"; ?><td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td></tr>
                                        <tr><td>APPR</td><?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['appraisalDays'] . ' days')) . "</td>"; ?><td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td></tr>
                                        <tr><td>LC</td><?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['lcDays'] . ' days')) . "</td>"; ?><td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td></tr>
                                        <tr><td>COE</td><?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['coeDays'] . ' days')) . "</td>"; ?><td><div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                </div></td></tr>
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

  

    </div>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
      
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
