<div class="modal inmodal fade" id="modalOrg" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-briefcase modal-icon"></i>
                <h4 class="modal-title">Create your Organization</h4>
                <small class="font-bold">Enterprise-X is the leading productivity Software.</small>
            </div>
            <div class="modal-body">
                <form method="POST" action="create_organization" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input type="text" name="name" class="form-control" placeholder="choose entity name" required autofocus/>
                        <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
                    </div>
                    <!-- configure getting client name from list of clients // a dropdown of clients -->
                    <div class="form-group has-feedback">
                        <input type="text" name="address" class="form-control" placeholder="address" required/>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="city" class="form-control" placeholder="city" required/>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="state" class="form-control" placeholder="state" required/>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="country" class="form-control" placeholder="country" />
                    </div>
                    {{--  <div class="form-group has-feedback">
                        <input type="text" name="zip" class="form-control" pattern="[0-9]{5}" title="Five digit zip code" placeholder="zip code" />
                    </div>  --}}
                    <div class="form-group has-feedback">
                        <table style="width:100%">
                            <tr>
                                <td>
                                    <select name="number_of_staff" class="form-control" placeholder="Number of staffs">
                                        <option value="">-- Number of staffs--</option>
                                        <option value="a"> 1 </option>
                                        <option value="b"> 2-9 </option>
                                        <option value="c"> 10-99 </option>
                                        <option value="d"> 100-299 </option>
                                        <option value="e"> >300 </option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="tel" name="phone_number" class="form-control" placeholder="Phone Number" required />
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="description" class="form-control" placeholder="Project description" />
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="industry" class="form-control" placeholder="Industry" />
                        {{--  <span class="fa fa-industry form-control-feedback"></span>  --}}
                    </div>
                    
            </div>
                <div class="modal-footer">
            <input type="submit" value="Submit" class="btn btn-primary">
                </form>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>                                            
            </div>
        </div>
    </div>
</div>
