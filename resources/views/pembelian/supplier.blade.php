      <div class="modal fade text-left modal-borderless" id="modal-supplier" tabindex="-1" role="dialog"
          aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Pilih Supplier</h5>
                      <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                          <i data-feather="x"></i>
                      </button>
                  </div>
                  <div class="modal-body">
                      <table class="table table-striped table-bordered table-supplier">
                          <thead>
                              <th width="5%">No</th>
                              <th>Nama</th>
                              <th>Tepelon</th>
                              <th>Alamat</th>
                              <th><i data-feather="settings"></i></th>
                          </thead>
                          <tbody>
                              @foreach ($supplier as $key => $s)
                                  <tr>
                                      <td width="5%">{{ $key + 1 }}</td>
                                      <td>{{ $s->nama }}</td>
                                      <td>{{ $s->telepon }}</td>
                                      <td>{{ $s->alamat }}</td>
                                      <td>
                                          <a href="{{ route('pembelian.create', $s->id_supplier) }}"
                                              class="btn btn-primary btn-xs btn-flat">
                                              <i data-feather="check-circle"></i>
                                              Pilih
                                          </a>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>

              </div>
          </div>
