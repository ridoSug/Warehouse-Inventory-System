  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">User</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">User</a></li>
                          <li class="breadcrumb-item active">Master Data</li>
                      </ol>
                  </div>
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <div class="card card-primary">
                          <div class="card-header">
                              Manage Data User
                          </div>
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-3">
                                      <button class="btn btn-primary" id="btn_add_user">
                                          <i class="fa fa-plus"></i> Add New User
                                      </button>
                                  </div>
                                  <div class="col-md-12 mt-3">
                                      <table class="table" id="table_user">
                                          <thead>
                                              <tr>
                                                  <th>No</th>
                                                  <th>Username</th>
                                                  <th>Name</th>
                                                  <th>Email</th>
                                                  <th>Level</th>
                                                  <th>Status</th>
                                                  <th>Action</th>
                                              </tr>
                                          </thead>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>

      <!-- Modal -->
      <form id="form_user" method="POST">
          <div class="modal fade" id="modal_user" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                              <label>Username</label>
                              <input type="hidden" name="id" id="id">
                              <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                          </div>
                          <div class="form-group">
                              <label>Name</label>
                              <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                          </div>
                          <div class="form-group">
                              <label>Email</label>
                              <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                          </div>
                          <div class="form-group">
                              <label>Level</label>
                              <select name="id_level" id="id_level" class="form-control select2" required></select>
                          </div>
                          <div class="form-group">
                              <label>Status</label>
                              <select name="status" id="status" class="form-control select2" required>
                                  <option value="">Select Status</option>
                                  <option value="1">Aktif</option>
                                  <option value="0">Tidak Aktif</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Password</label>
                              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                              <span class="help-text">Biarkan kosong jika tidak ingin mengganti password.</span>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                  </div>
              </div>
          </div>
      </form>
      <!-- End Modal -->
  </div>
  <script>
      $(document).ready(function() {
          var mode = 'add';

          var table = $('#table_user').DataTable({
              ajax: {
                  url: "<?= site_url('user/get_ajax_data_user') ?>",
              },
              order: [],
              columns: [{
                      data: 'id',
                      orderable: false,
                  },
                  {
                      data: 'username'
                  },
                  {
                      data: 'name'
                  },
                  {
                      data: 'email'
                  },
                  {
                      data: 'level'
                  },
                  {
                      data: 'status',
                      render: function(data, type, row) {
                          var btn_aktif = '<button class="btn btn-success btn-sm">Aktif</button>';
                          var btn_non_aktif = '<button class="btn btn-danger btn-sm">Tidak Aktif</button>';
                          if (data == 1) {
                              return btn_aktif;
                          } else {
                              return btn_non_aktif;
                          }
                      }
                  },
                  {
                      data: 'id',
                      render: function(data, type, row) {
                          var btn_edit = '<button class="btn btn-primary btn-edit mr-1 mb-1"><i class="fa fa-edit"></i></button>';
                          var btn_delete = '<button class="btn btn-danger btn-delete mr-1 mb-1"><i class="fa fa-trash"></i></button>';
                          return btn_edit + btn_delete;
                      }
                  },
              ],
              "responsive": true,
              "autoWidth": false,
              dom: 'Bfrtip',
              lengthMenu: [
                  [10, 25, 50, -1],
                  ['10 rows', '25 rows', '50 rows', 'Show all']
              ],
              buttons: [
                  'pageLength',
                  'excel',
                  {
                      text: 'Refresh',
                      action: function(e, dt, node, config) {
                          table.ajax.reload();
                      }
                  }
              ],
          })

          function init_select_level() {
              $("[name='id_level'").select2({
                  ajax: {
                      url: "<?= site_url('user/get_ajax_data') ?>",
                      type: "POST",
                      dataType: 'JSON',
                      delay: 250,
                      data: function(params) {
                          return {
                              searchTerm: params.term, // search term
                          };
                      },
                      processResults: function(response) {
                          return {
                              results: response
                          };
                      },
                      cache: true
                  },
                  placeholder: 'Select Level user',
              });
          }

          $('#btn_add_user').on('click', function() {
              init_select_level();
              $('#modal_user .modal-title').html('Add New User');
              if (mode == 'edit') {
                  $('[name=id]').val('');
                  $('[name=username]').val('');
                  $('[name=name]').val('');
                  $('[name=password]').val('');
                  $('[name=id_level]').val('').change();
              }
              mode = 'add';
              $('[name=password]').prop('required', true);
              $('.help-text').hide();
              $('#modal_user').modal();
          })

          $('#table_user').on('click', '.btn-edit', function() {
              init_select_level();
              $('[name=password]').prop('required', false);
              $('#password').val('').change();
              $('.help-text').show();

              mode = 'edit';

              var row = table.row($(this).parent().parent()).data();
              $.each(row, function(i, d) {
                  $('#' + i).val(d).change();
              })

              var option = new Option(row['level'], row['id_level'], true, true);
              $('#id_level').append(option).trigger('change');

              $('#modal_user .modal-title').html('Edit Data User');
              $('#modal_user').modal();
          })

          $('#table_user').on('click', '.btn-delete', function() {
              var row = table.row($(this).parent().parent()).data();
              if (confirm('Are you sure want to delete this data ?')) {
                  $.ajax({
                      url: "<?= site_url('user/delete_data') ?>",
                      data: {
                          id: row['id']
                      },
                      type: 'POST',
                      beforeSend: function() {},
                      success: function(result) {
                          if (result) {
                              try {
                                  result = JSON.parse(result);
                                  $('#modal_general .modal-body').html(result.message);
                                  if (result.code == 200) {
                                      table.ajax.reload();
                                      hide_modal();
                                  }
                                  $('#modal_general').modal('show');
                              } catch (e) {
                                  console.log(e);
                                  alert(result);
                              }
                          }
                      },
                      error: function(xhr, ajaxOptions, thrownError) {
                          console.log(xhr.status + " : " + thrownError);
                          swal('Delete Data Gagal', 'error');
                      }
                  })
              }
          })

          $('#form_user').on('submit', function(e) {
              e.preventDefault();
              if (confirm('Are you sure want to submit this data ?')) {
                  var formData = new FormData($(this)[0]);
                  $.ajax({
                      url: "<?= site_url('user/save_data') ?>",
                      data: formData,
                      processData: false,
                      contentType: false,
                      async: false,
                      cache: false,
                      enctype: 'multipart/form-data',
                      type: 'POST',
                      beforeSend: function() {
                          $('button[type=submit]').prop('disabled', true);
                      },
                      success: function(result) {
                          if (result) {
                              try {
                                  result = JSON.parse(result);

                                  $('#modal_general .modal-body').html(result.message);
                                  if (result.code == 200) {
                                      table.ajax.reload();
                                      hide_modal();
                                  }
                                  $('#modal_general').modal('show');
                              } catch (e) {
                                  console.log(e);
                                  alert(result);
                              }
                          }
                          $('button[type=submit]').prop('disabled', false);
                      },
                      error: function(xhr, ajaxOptions, thrownError) {
                          console.log(xhr.status + ' : ' + thrownError);
                          alert('Ada kesalahan : ' + xhr.status + ' : ' + thrownError);
                          $('button[type=submit]').prop('disabled', false);
                      }
                  })
              }
          })
      })
  </script>