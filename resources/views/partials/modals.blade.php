<div class="row">
    <div id="modal-delete-confirm" class="modal">
        <form id="delete-confirm-form" action="" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
            <div class="modal-content">
                <h5></h5>
                <p>Are you sure want to do this?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                <button type="submit" class="modal-action waves-effect waves-green btn-flat">Remove</button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div id="modal-import-excel" class="modal">
        <form id="import-excel-form" action="" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <h5></h5>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Click to add...</span>
                        <input type="file" name="excel" required>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                <button type="submit" class="modal-action waves-effect waves-green btn-flat">Import</button>
            </div>
        </form>
    </div>
</div>