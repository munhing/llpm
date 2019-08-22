<!-- password modal -->

<div class="modal fade modal-auth" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-sm">
          <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Please enter your password</h4>
                </div>
          <div class="modal-body">
                <form class="form-password">
                      <div class="form-group">
                            {{ Form::password('auth_password', ['id'=>'auth_password', 'class'=>'form-control']) }}
                      </div>
                      <button class="btn btn-lg btn-primary btn-block" data-auth="" data-submit-form="abc">
                            Submit
                      </button>                  
                </form>
          </div>

          </div>
    </div>
</div>