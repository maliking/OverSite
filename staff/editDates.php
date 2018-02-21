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
    <button type="button"  data-toggle="modal" <?php echo "data-target=#editDateModal".$trans['transId'];?>>
  <i class="fa fa-edit"></i>
</button>
    <!--MODAL AREA!!-->


    <div class="modal " <?php echo "id=editDateModal" . $trans['transId'];?>>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                   <?php echo $trans['address']; ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
        
                        
                       
                            
                                    
                                    <table id="modal-table" >
                                        
                                    </table>
                                   
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                                </button>

                                <button type="button" class="btn btn-default pull-left" 
                                onClick=<?php echo "deleteInContract(" . $trans['transId'] . ")"; ?>>Delete
                                </button>

                <button type="button" class="btn btn-default" onClick=<?php echo "saveNewDates(" . $trans['transId'] . ")"; ?>>Save
                                </button>
            </div>
                              </div>
                                <!-- /.box-body -->
                            
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
