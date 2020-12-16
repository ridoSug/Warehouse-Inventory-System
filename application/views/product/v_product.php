  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Product</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Product</a></li>
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
                              Manage Data Product
                              <div class="pull-right">
                                  <a href="<?= site_url('product') ?>" class="btn btn-danger">Back</a>
                              </div>
                          </div>
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-3">
                                      <button class="btn btn-primary" id="btn_add_product">
                                          <i class="fa fa-plus"></i> Add New Product
                                      </button>
                                  </div>
                                  <div class="col-md-12 mt-3">
                                      <table class="table" id="table_product">
                                          <thead>
                                              <tr>
                                                  <th>No</th>
                                                  <th>Code</th>
                                                  <th>Name</th>
                                                  <th>UoM</th>
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
      <form id="form_product" method="POST">
          <div class="modal fade" id="modal_product" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" name="id" id="id">
                          <div class="form-group">
                              <label>Code</label>
                              <input type="text" name="code" id="code" class="form-control" placeholder="Product Code" readonly>
                          </div>
                          <div class="form-group">
                              <label>Name</label>
                              <input type="text" name="name" id="name" class="form-control" placeholder="Product Name" required>
                          </div>
                          <div class="form-group">
                              <label>Unit of Measure</label>
                              <select name="id_uom" id="id_uom" class="form-control select2" required></select>
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

          var table = $('#table_product').DataTable({
              ajax: {
                  url: "<?= site_url('product/get_ajax_data') ?>",
                  data: function(d) {
                      //d.id_warehouse = id_warehouse;
                  }
              },
              order: [],
              columns: [{
                      data: 'id',
                      orderable: false,
                  },
                  {
                      data: 'code',
                  },
                  {
                      data: 'name'
                  },
                  {
                      data: 'uom'
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

          function init_select_uom() {
              $("[name='id_uom'").select2({
                  ajax: {
                      url: "<?= site_url('product/get_ajax_data_select_uom') ?>",
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
                  placeholder: 'Select Unit Type',
              });
          }

          $('#btn_add_product').on('click', function() {
              init_select_uom();
              $('#modal_product .modal-title').html('Add New Product');
              if (mode == 'edit') {
                  $('[name=id]').val('');
                  $('[name=name]').val('');
                  $('[name=id_uom]').val('').change();
              }
              mode = 'add';
              $('#modal_product').modal();
          })

          $('#table_product').on('click', '.btn-edit', function() {
              mode = 'edit';

              var row = table.row($(this).parent().parent()).data();
              $.each(row, function(i, d) {
                  $('#' + i).val(d).change();
              })

              var option = new Option(row['uom'], row['id_uom'], true, true);
              $('#id_uom').append(option).trigger('change');

              $('#modal_product .modal-title').html('Edit Data Product');
              $('#modal_product').modal();
          })

          $('#table_product').on('click', '.btn-delete', function() {
              var row = table.row($(this).parent().parent()).data();
              if (confirm('Are you sure want to delete this data ?')) {
                  $.ajax({
                      url: "<?= site_url('product/delete_data') ?>",
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

          $('#form_product').on('submit', function(e) {
              e.preventDefault();
              if (confirm('Are you sure want to submit this data ?')) {
                  var formData = new FormData($(this)[0]);
                  //formData.append('id_warehouse', id_warehouse);
                  $.ajax({
                      url: "<?= site_url('product/save_data') ?>",
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