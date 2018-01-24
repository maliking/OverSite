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


    <div class="modal fade" <?php echo "id=editDateModal" . $trans['transId'];?>>
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
                                        <th>Days</th>
                                        <th>New Date</th>
                                        </tr>
                                        <tr>
                                            <td>Aprv</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day)) . "</td>"; ?> 
                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','aprv',this)"; ?> <?php echo "id=aprvDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day));?>>
                                                </div>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td>EMD</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['emdDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','emd',this)"; ?> <?php echo "id=emdDayNum".$trans['transId'];?> value=<?php echo $trans['emdDays'] ;?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','emd',this)"; ?> <?php echo "id=emdDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['emdDays'] . ' days'));?>>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>DISC</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['sellerDiscDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','seller',this)"; ?> <?php echo "id=sellerDayNum".$trans['transId'];?> value=<?php echo $trans['sellerDiscDays'] ;?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','seller',this)"; ?> <?php echo "id=sellDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['sellerDiscDays'] . ' days'));?>>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td>INSP</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['genInspecDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','generalInspec',this)"; ?> <?php echo "id=genInspecDayNum".$trans['transId'];?> value=<?php echo $trans['genInspecDays'] ;?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','generalInspec',this)"; ?> <?php echo "id=genDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['genInspecDays'] . ' days'));?>>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>APPR</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['appraisalDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','appr',this)"; ?> <?php echo "id=apprDayNum".$trans['transId'];?> value=<?php echo $trans['appraisalDays'] ;?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','appr',this)"; ?> <?php echo "id=apprvDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['appraisalDays'] . ' days'));?>>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LC</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['lcDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','lc',this)"; ?> <?php echo "id=lcDayNum".$trans['transId'];?> value=<?php echo $trans['lcDays'] ;?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','lc',this)"; ?> <?php echo "id=lcDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['lcDays'] . ' days'));?>>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>COE</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['coeDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','coe',this)"; ?> <?php echo "id=coeDayNum".$trans['transId'];?> value=<?php echo $trans['coeDays'] ;?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','coe',this)"; ?> <?php echo "id=coeDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['coeDays'] . ' days'));?>>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    </form>  
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                                </button>
                <button type="button" class="btn btn-default" onClick=<?php echo "saveNewDates(" . $trans['transId'] . ")"; ?>>Save
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
