<!-- Modal -->
<div id="noteModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="height:100%;">

    <!-- Modal content-->
    <div class="modal-content" style="height:95%;">
      <div class="modal-header" style="border-bottom: solid 2px black">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notes</h4>
        <p id="favoriteId" hidden></p>
      </div>
      <div class="modal-body" style="height:70%; overflow: auto;">

        <table id="noteTable" style="border-collapse:separate; border-spacing: 0 15px;" >

      </table>
      </div>
      <div class="modal-footer" style="border-top: solid 2px black">
        <textarea class="form-control" rows="2" id="addNewNoteArea" style="resize:none;" placeholder="Add new note"></textarea>
      </br>
        <?php echo '<td><button type="button" class="btn btn-default" onClick=sendNotesText(' . $favorite['phone'] . ')>Text Notes</button></td>'; ?>
        <button type="button" class="btn btn-default" onClick="addNewNote()">Add</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- -->

<!-- Modal -->
  <div id="lastContactedModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p id="favoriteIdContact" hidden></p>          
        </div>
        <div class="modal-body">
          <button onClick="updateLastContacted('Contacted by Phone')">Phone</button>
          <button onClick="updateLastContacted('Contacted by Email')">Email</button>
          <button onClick="updateLastContacted('Contacted by Walk-in')">Walk-in</button>
          <button onClick="updateLastContacted('Contacted by Text')">Text</button>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
</div>
