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
                                        <tr>
                                        <th>Type</th>
                                        <th>Current Date</th>
                                        <th>Days</th>
                                        <th>New Date</th>
                                        <th>Ordered Date</th>
                                        <th>Completed Date</th>
                                        </tr>
                                        <tr>
                                            <td>Acc</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day)) . "</td>"; ?> 
                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date" >
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','aprv',this)"; ?> <?php echo "id=aprvDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day));?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
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
                                                    <input  class="col"type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','emd',this)"; ?> <?php echo "id=emdDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['emdDays'] . ' days'));?>>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['emdComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","emd",this) id=emdDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","emd",this)  id=emdDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['emdComp'] . '>';

                                                        }
                                                    ?>
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
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','seller',this)"; ?> <?php echo "id=sellDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['sellerDiscDays'] . ' days'));?>>
                                                </div>
                                            </td> 

                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['sellerDiscComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","seller",this) id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","seller",this)  id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['sellerDiscComp'] . '>';

                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Signed Disc.</td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['signedDiscDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','signed',this)"; ?> <?php echo "id=signedDayNum".$trans['transId'];?> value=<?php echo $trans['signedDiscDays'] ;?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','signed',this)"; ?> <?php echo "id=signedDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['signedDiscDays'] . ' days'));?>>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['signedDiscComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","signed",this) id=signedDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","signed",this)  id=signedDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['signedDiscComp'] . '>';

                                                        }
                                                    ?>
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
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','generalInspec',this)"; ?> <?php echo "id=genDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['genInspecDays'] . ' days'));?>>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['genInspecComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","generalInspec",this) id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","generalInspec",this)  id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['genInspecComp'] . '>';

                                                        }
                                                    ?>
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
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','appr',this)"; ?> <?php echo "id=apprvDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['appraisalDays'] . ' days'));?>>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    <?php
                                                        if($trans['apprOrdered'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveOrdDate("'.$trans['transId'] . '","appr",this) id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveOrdDate("'.$trans['transId'] . '","appr",this)  id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['apprOrdered'] . '>';

                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['apprComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","appr",this) id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","appr",this)  id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['apprComp'] . '>';

                                                        }
                                                    ?>
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
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','lc',this)"; ?> <?php echo "id=lcDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['lcDays'] . ' days'));?>>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['lcComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","lc",this) id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","lc",this)  id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['lcComp'] . '>';

                                                        }
                                                    ?>
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
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','coe',this)"; ?> <?php echo "id=coeDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['coeDays'] . ' days'));?>>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['coeComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","coe",this) id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","coe",this)  id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['coeComp'] . '>';

                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><input style="width: 50px;" type="text" value=<?php echo "\"" . $trans['miscOneName'] . "\""?> onChange=<?php echo "saveNameMisc('" . $trans['transId'] . "','miscOne',this)"; ?>></td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['miscOneDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','miscOne',this)"; ?> <?php echo "id=miscDayNum".$trans['transId'];?> value=<?php echo $trans['miscOneDays'] ;?>>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','miscOne',this)"; ?> <?php echo "id=miscDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['miscOneDays'] . ' days'));?>>

                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['miscOneComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","miscOne",this) id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","miscOne",this)  id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['miscOneComp'] . '>';

                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><input style="width: 50px;" type="text" value=<?php echo "\"" . $trans['miscTwoName'] . "\"" ?> onChange=<?php echo "saveNameMisc('" . $trans['transId'] . "','miscTwo',this)"; ?>></td>
                                            <?php echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['miscTwoDays'] . ' days')) . "</td>"; ?>
                                            <td>
                                                <div>
                                                    <input type="text" class="form-control pull-right" onChange=<?php echo "saveDaysNum('" . $trans['transId'] . "','miscTwo',this)"; ?> <?php echo "id=miscTwoDayNum".$trans['transId'];?> value=<?php echo $trans['miscTwoDays'] ;?>>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input class="col" type="date" class="form-control pull-right" onChange=<?php echo "saveDateCalendar('" . $trans['transId'] . "','miscTwo',this)"; ?> <?php echo "id=miscTwoDay".$trans['transId'];?> placeholder="&#xf073;" value=<?php echo date('Y-m-d', strtotime($day . ' + '. $trans['miscTwoDays'] . ' days'));?>>

                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <?php
                                                        if($trans['miscTwoComp'] == NULL)
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","miscTwo",this) id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value="" >';

                                                        }
                                                        else
                                                        {
                                                            echo '<input class="col" type="date" class="form-control pull-right" onChange=saveCompDate("'.$trans['transId'] . '","miscTwo",this)  id=sellDay'.$trans['transId'].' placeholder="&#xf073;" value=' . $trans['miscTwoComp'] . '>';

                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
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
