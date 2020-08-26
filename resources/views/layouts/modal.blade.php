<!-- logout modal -->
<div class="modal fade" id="logoutModal" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="submit" value="Logout" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- confirm modal -->
<div class="modal fade" id="confirmModal" tabIndex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Apakah anda sudah yakin dengan data yang diisi pada form Berikut ?
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Tidak</button>
                <button id="btnSaveConfirm" class="btn btn-success">Yakin</button>
            </div>
        </div>
    </div>
</div>

<!-- back modal -->
<div class="modal fade" id="backModal" tabIndex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Data yang terisi akan hilang, Apakah anda ingin kembali ke halaman awal ?
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-success" href="{{ url()->previous() }}">Yakin</a>
            </div>
        </div>
    </div>
</div>