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
                      <div class="form-group" style="width: 150px;">
                          <label for="kategori" style="font-size: 12px;">Filter Kategori :</label>
                          <select class="form-control" id="kategori"
                              style="font-size: 12px; padding: 5px; width: 100%;">
                              <option value="">Semua Kategori</option>
                              @foreach ($kategori as $k)
                                  <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                              @endforeach
                          </select>
                      </div>
                      <table class="table table-striped table-bordered table-produk">
                          <thead>
                              <th width="5%">No</th>
                              <th>Kode</th>
                              <th>Nama</th>
                              <th>Harga Jual</th>
                              <th>Stok</th>
                              <th><i data-feather="settings"></i></th>
                          </thead>
                          <tbody>
                              @foreach ($produk as $key => $p)
                                  <tr data-kategori="{{ $p->id_kategori }}">
                                      <td width="5%">{{ (int) $key + 1 }}</td>
                                      <td><span class="badge bg-success">{{ $p->kode_produk }}</span></td>
                                      <td>{{ $p->nama_produk }}</td>
                                      <td>{{ $p->harga_jual }}</td>
                                      <td>{{ $p->stok }}</td>
                                      @if ($p->stok == 0)
                                          <td>
                                              <a href="#" class="btn disabled btn-primary btn-xs btn-flat"
                                                  onclick="pilihProduk('{{ $p->id_produk }}', '{{ $p->kode_produk }}')">
                                                  <i data-feather="check-circle"></i>
                                                  Pilih
                                              </a>
                                          </td>
                                      @else
                                          <td>
                                              <a href="#" class="btn btn-primary btn-xs btn-flat"
                                                  onclick="pilihProduk('{{ $p->id_produk }}', '{{ $p->kode_produk }}')">
                                                  <i data-feather="check-circle"></i>
                                                  Pilih
                                              </a>
                                          </td>
                                      @endif
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>

              </div>
          </div>
