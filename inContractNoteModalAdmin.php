<!-- Modal -->
<div id="incontractNoteModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="height:100%;">

    <!-- Modal content-->
    <div class="modal-content" style="height:95%;">
      <div class="modal-header" style="border-bottom: solid 2px black">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notes</h4>
        <p id="transId" hidden></p>
      </div>
      <div class="modal-body" style="height:70%; overflow: auto;">

        <table id="inContractNoteTable" style="border-collapse:separate; border-spacing: 0 15px;" >

      </table>
      </div>
      <div class="modal-footer" style="border-top: solid 2px black">
        <textarea class="form-control" rows="2" id="addNewNoteInContractArea" style="resize:none;" placeholder="Add new note"></textarea>
      </br>
        <?php echo '<td><button type="button" class="btn btn-default" onClick=sendNotesText("8312764194")>Text Notes</button></td>'; ?>
        <button type="button" class="btn btn-default" onClick="addNewNoteInContract()">Add</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- -->

</div>
