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
         input.empty {
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
}


    </style>

    <!-- Button trigger modal -->
    <button type="button"  data-toggle="modal" data-target="#modal">
  <h6>Text Agent</h6>
</button>
    <!--MODAL AREA!!-->


    <div class="modal modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                 <small>  Message to <?php echo $agentResult['firstName'] . " " . $agentResult['lastName']; ?></small>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        
                                    
            <div class="box-body">
              <form>
                    <textarea id="editor1" name="editor1" rows="10" cols="40" style="color:black;" placeholder="Text"></textarea>
              </form>
            </div>
       
                    </div>

             
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                                </button>
                <button type="button" class="btn-default pull-right" onClick="sendText()">Send 
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
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })

  function sendText()
  {
    // alert($("#editor1").val());
    $.post( "sendText.php", { phone: $("#hiddenPhone").html() , text: $("#editor1").val() })
      .done(function( data ) {
        alert("Message Sent");
      });
  }
</script>

</body>

</html>
