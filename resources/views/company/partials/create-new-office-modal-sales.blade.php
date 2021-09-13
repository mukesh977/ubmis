<div class="modal fade" id="salesOfficeModal">
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
          <label for="Office Name">Office Name <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
          <input type="text" name="name" id="name" placeholder="Enter Office Name" class="form-control">
        </div>

        <div class="form-group" id="form-group-address">
          <label for="Address">Address <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
          <input type="text" name="address" id="address" placeholder="Enter Address" class="form-control">
        </div>


        <div class="form-group" id="form-group-email">  
          <label for="Email">E-mail <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
          <!-- <input type="text" name="contactNumber" id="contactNumber" placeholder="Enter Contact Number" class="form-control"> -->
          
          <div id="emailTable">
            <table class="table table-responsive-sm table-bordered" style="margin-bottom: 0px;">
              <tbody>
                  <tr>
                    <td width="95%">
                      <input type="text" name="email[]" id="email" placeholder="Enter E-mail" class="form-control">
                    </td>
                    <td width="5%">
                      <a href="" class="link email_add">
                        <i class="fa fa-plus" style="margin-top: 10px;"></i>
                      </a>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="form-group" id="form-group-contactno">  
          <label for="Contact No">Contact Number <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
          <!-- <input type="text" name="contactNumber" id="contactNumber" placeholder="Enter Contact Number" class="form-control"> -->
          
          <div id="contactTable">
            <table class="table table-responsive-sm table-bordered" style="margin-bottom: 0px;">
              <tbody>
                  <tr>
                    <td width="95%">
                      <input type="text" name="contactNumber[]" id="contactNumber" placeholder="Enter Contact Number" class="form-control">
                    </td>
                    <td width="5%">
                      <a href="" class="link phone_add">
                        <i class="fa fa-plus" style="margin-top: 10px;"></i>
                      </a>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>

        <span class="help-block" style="color: #f00"></span>
        <span class="help-block" style="color: #000; position: relative;
  top: 15px;">Note: Please enter 1<sup>st</sup> row email as primary.</span>
      </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="save-new-office-sales" class="btn btn-primary">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
