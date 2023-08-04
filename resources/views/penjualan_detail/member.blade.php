      <div class="modal fade text-left modal-borderless" id="modal-member" tabindex="-1" role="dialog"
          aria-labelledby="myModalLabel1">
          <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Pilih Member</h5>
                      <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                          <i data-feather="x"></i>
                      </button>
                  </div>
                  <div class="modal-body">
                      <table class="table table-striped table-bordered table-member">
                          <thead>
                              <th width="5%">No</th>
                              <th>Nama</th>
                              <th>Tepelon</th>
                              <th>Alamat</th>
                              <th><i data-feather="settings"></i></th>
                          </thead>
                          <tbody>
                              @foreach ($member as $key => $m)
                                  <tr>
                                      <td width="5%">{{ $key + 1 }}</td>
                                      <td>{{ $m->nama }}</td>
                                      <td>{{ $m->telepon }}</td>
                                      <td>{{ $m->alamat }}</td>
                                      <td>
                                          <a href="#" class="btn btn-primary btn-xs btn-flat"
                                              onclick="pilihMember('{{ $m->id_member }}', '{{ $m->kode_member }}')">
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
