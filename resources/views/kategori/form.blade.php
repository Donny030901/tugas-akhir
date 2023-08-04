      <div class="modal fade text-left modal-borderless" id="modal-form" tabindex="-1" role="dialog"
          aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable" role="document">
              <form action="" method="post" class="form-horizontal">
                  @csrf
                  @method('post')


                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title"></h5>
                          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                              <i data-feather="x"></i>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group row">
                              <label for="nama_kategori" class="col-lg-2 col-lg-offset-1 control-label">Kategori</label>
                              <div class="col-lg-10">
                                  <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                                      required autofocus>
                                  <span class="help-block with-errors"></span>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-primary ms-1">
                              <span class="d-none d-sm-block">Simpan</span>
                          </button>
                          <button class="btn btn-light-primary">
                              <span class="d-none d-sm-block">Batal</span>
                          </button>
                      </div>
                  </div>
              </form>

          </div>
      </div>
