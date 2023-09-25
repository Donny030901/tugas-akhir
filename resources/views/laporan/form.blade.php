      <div class="modal fade text-left modal-borderless" id="modal-form" tabindex="-1" role="dialog"
          aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable" role="document">
              <form action="{{ route('laporan.index') }}" method="get" class="form-horizontal">
                  {{-- @csrf
                  @method('post') --}}


                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title"> Periode Laporan</h5>
                          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                              <i data-feather="x"></i>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group row">
                              <label for="tanggal_awal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal
                                  Awal</label>
                              <div class="col-lg-10">
                                  <input type="text" name="tanggal_awal" id="tanggal_awal"
                                      class="form-control flatpickr" required autofocus
                                      value="{{ request('tanggal_awal') }}">
                                  <span class="help-block with-errors"></span>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="tanggal_akhir" class="col-lg-2 col-lg-offset-1 control-label">Tanggal
                                  Akhir</label>
                              <div class="col-lg-10">
                                  <input type="text" name="tanggal_akhir" id="tanggal_akhir"
                                      class="form-control flatpickr" required autofocus
                                      value="{{ request('tanggal_akhir') }}"">
                                  <span class="help-block
                                      with-errors"></span>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-primary ms-1">
                              <span class="d-none d-sm-block">Simpan</span>
                          </button>
                          <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                              <span class="d-none d-sm-block">Batal</span>
                          </button>
                      </div>
                  </div>
              </form>

          </div>
      </div>
