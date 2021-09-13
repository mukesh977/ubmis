<div class="modal fade" id="officeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Office</h4>
            </div>
            <div class="modal-body">
                {{ csrf_field() }}
                <div class="form-group" id="form-group-name">
                    <label for="Name">Name <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                    <input type="text" name="name" id="name" placeholder="Enter Purpose" class="form-control">
                    <span class="help-block"></span>
                </div>
                <div class="form-group" id="form-group-address">
                    <label for="address">Address <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                    <input type="text" name="officeAddress" id="officeAddress" placeholder="Enter Address" class="form-control">
                    <span class="help-block officeAddress"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="save-new-office" class="btn btn-primary">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>