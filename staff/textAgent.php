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

    </style>

    <!-- Button trigger modal -->
    <button type="button"  data-toggle="modal" data-target="#modal-primary">
  <h6>Text Agent</h6>
</button>
    <!--MODAL AREA!!-->


    <div class="modal modal-primary fade" id="modal-primary">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <small style="color: white;">Message to John Doe</small>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        
                                    
            <div class="box-body">
              <form>
                    <textarea id="editor1" name="editor1" rows="10" cols="45" style="color:black;" placeholder="text">
</textarea>
              </form>
            </div>
       
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close
                                </button>
                <button type="button" class="btn btn-outline">Send 
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
