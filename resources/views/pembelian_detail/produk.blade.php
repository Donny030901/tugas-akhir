      <div class="modal fade text-left modal-borderless" id="modal-produk" tabindex="-1" role="dialog"
          aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Pilih Produk</h5>
                      <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                          <i data-feather="x"></i>
                      </button>
                  </div>
                  <div class="modal-body">
                      <table class="table table-striped table-bordered table-produk">
                          <thead>
                              <th width="5%">No</th>
                              <th>Kode</th>
                              <th>Nama</th>
                              <th>Harga Beli</th>
                              <th><i data-feather="settings"></i></th>
                          </thead>
                          <tbody>
                              @foreach ($produk as $key => $p)
                                  <tr>
                                      <td width="5%">{{ (int) $key + 1 }}</td>
                                      <td><span class="badge bg-success">{{ $p->kode_produk }}</span></td>
                                      <td>{{ $p->nama_produk }}</td>
                                      <td>{{ $p->harga_beli }}</td>
                                      <td>
                                          <a href="#" class="btn btn-primary btn-xs btn-flat"
                                              onclick="pilihProduk('{{ $p->id_produk }}', '{{ $p->kode_produk }}')">
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
