  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Form Order</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Inbound</a></li>
                          <li class="breadcrumb-item active">Form Data</li>
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
                              Data Order Inbound
                          </div>
                          <form id="form_order" method="POST">
                              <div class="card-body">
                                  <div class="row">
                                      <!-- ROW -->
                                      <div class="col-md-12">
                                          <div class="row">
                                              <div class="col-md-3">
                                                  <label>Estimate Inbound Date</label>
                                                  <input type="hidden" name="id" id="id">
                                                  <input type="date" name="inbound_date" id="inbound_date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                                              </div>
                                              <div class="col-md-3">
                                                  <label>Truck No</label>
                                                  <input type="text" name="truck_no" id="truck_no" class="form-control" required>
                                              </div>
                                              <div class="col-md-3">
                                                  <label>Driver Name</label>
                                                  <input type="text" name="driver_name" id="driver_name" class="form-control" required>
                                              </div>
                                              <div class="col-md-3">
                                                  <label>PO Number</label>
                                                  <input type="text" name="po_number" id="po_number" class="form-control">
                                              </div>
                                          </div>
                                      </div>
                                      <!-- END ROW -->

                                      <!-- ROW  -->
                                      <div class="col-md-12 mt-3">
                                          <div class="row">
                                              <div class="col-md-3">
                                                  <label>Origin</label>
                                                  <select name="id_origin" id="id_origin" class="form-control" required></select>
                                              </div>
                                              <div class="col-md-3">
                                                  <label>Warehouse Destination</label>
                                                  <select name="id_warehouse" id="id_warehouse" class="form-control" required></select>
                                              </div>
                                              <div class="col-md-3">
                                                  <label>Creator</label>
                                                  <input type="hidden" id="id_user_created" name="id_user_created">
                                                  <input type="text" id="name_creator" name="name_creator" class="form-control-plaintext" readonly>
                                              </div>
                                          </div>
                                      </div>

                                      <!-- END ROW -->
                                  </div>
                              </div>
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-8">
                                          <table class="table" id="table_product">
                                              <thead>
                                                  <tr>
                                                      <th style="width: 35%;">Description</th>
                                                      <th style="width: 10%;">Qty</th>
                                                      <th style="width: 10%;">Unit</th>
                                                      <th style="width: 30%;">Site Name</th>
                                                      <th></th>
                                                  </tr>
                                              </thead>
                                              <tbody></tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                              <div class="card-footer">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <button type="button" class="btn btn-primary btn-add-product">
                                              <i class="fa fa-plus"> </i> Add Rows
                                          </button>

                                          <button type="submit" class="btn btn-success btn-save">
                                              <i class="fa fa-save"> </i> Save
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </section>
  </div>

  <script>
      $(document).ready(function() {
          var id_karyawan = "<?= $id_user ?>"
          var nama_karyawan = "<?= $name_user ?>"
          var id = "<?= $id ?>"
          var mode = "<?= $mode ?>"
          var id_trash = [];

          if (id == '') {
              $('[name=id_user_created]').val(id_karyawan);
              $('[name=name_creator]').val(nama_karyawan);
          } else {

          }

          function get_info(id = '') {
              $.ajax({
                  url: "<?= site_url('inbound/info_order') ?>",
                  data: {
                      id: id
                  },
                  type: 'GET',
                  beforeSend: function() {},
                  success: function(result) {
                      if (result) {
                          try {
                              result = JSON.parse(result);

                              if (result.code == 200) {
                                  //header
                                  var header = result.header;
                                  $.each(header, function(i, d) {
                                      $('#' + i).val(d).change();
                                  })

                                  var option = new Option(header['origin'], header['id_origin'], true, true);
                                  $('#id_origin').append(option).trigger('change');
                                  var option = new Option(header['warehouse'], header['id_warehouse'], true, true);
                                  $('#id_warehouse').append(option).trigger('change');

                                  $('[name=inbound_date]').prop('min', header['inbound_date']).change();

                                  var body = result.body;

                                  $.each(body, function(i, d) {
                                      add_row();
                                      $('[name="id_detail[]"').eq(i).val(d.id);
                                      var option = new Option(d.product, d.id_product, true, true);
                                      $('[name="id_product[]"').eq(i).append(option).trigger('change');

                                      var data = $('[name="id_product[]"').eq(i).select2('data')[0];
                                      data['uom'] = d.uom;
                                      $('[name="qty[]"').eq(i).val(d.qty);
                                      $('[name="uom_product[]"').eq(i).val(d.uom);
                                      $('[name="site_name[]"').eq(i).val(d.site_name);
                                  })
                                  init_select_product();
                              } else {

                              }
                          } catch (e) {
                              console.log(e);
                              Swal.fire(result, '', 'error')
                          }
                      }
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + " : " + thrownError);
                  }
              })
          }

          function init_select_product() {
              $("[name='id_product[]'").select2({
                  ajax: {
                      url: "<?= site_url('product/get_ajax_data_select') ?>",
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
                  placeholder: 'Select Product',
              });
          }

          function add_row() {
              var _tr = '<tr>';
              _tr += '<td><select style="width:400px" name="id_product[]" class="form-control select2" required></select></td>';
              _tr += '<td><input style="width:140px" type="number" step="0.01" name="qty[]" class="form-control" required></td>';
              _tr += '<td><input name="uom_product[]" class="form-control-plaintext" readonly></td>';
              _tr += '<td><input type="text" name="site_name[]" class="form-control" required></td>';
              _tr += `<td>
              <input type="hidden" name="id_detail[]" value="0">
              <button type="button" class="btn btn-danger btn-trash"><i class="fa fa-trash"></i></button>
              </td>`;
              _tr += '</tr>';

              $('#table_product tbody').append(_tr);
              init_select_product();
          }

          function lock_warehouse() {
              $('[name=id_warehouse]').prop('disabled', true);
          }

          function unlock_warehouse() {
              $('[name=id_warehouse]').prop('disabled', false);
          }

          function save_form(formData) {
              $.ajax({
                  url: "<?= site_url('inbound/save_order') ?>",
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
                              if (result.code == 200) {

                                  if (mode == 'add') {
                                      Swal.fire({
                                          title: 'Inbound Number : ' + result.data.inbound_no,
                                          confirmButtonText: `OK`,
                                          allowOutsideClick: false,
                                          allowEscapeKey: false,
                                          icon: 'success'
                                      }).then((result) => {
                                          /* Read more about isConfirmed, isDenied below */
                                          if (result.isConfirmed) {
                                              location.reload();
                                          }
                                      })
                                  } else {
                                      Swal.fire({
                                          title: result.message,
                                          icon: 'succes',
                                          timer: 500,
                                      }).then(function() {
                                          window.location.href = "<?= site_url('inbound') ?>"
                                      })
                                  }
                              } else {
                                  Swal.fire(result.message, '', 'info')
                              }
                          } catch (e) {
                              console.log(e);
                              Swal.fire(result, '', 'error');
                          }
                      }
                      $('button[type=submit]').prop('disabled', false);
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                      console.log(xhr.status + ' : ' + thrownError);
                      Swal.fire(xhr.status + ' : ' + thrownError, '', 'error');
                      $('button[type=submit]').prop('disabled', false);
                  }
              })
          }

          $("[name='id_origin']").select2({
              ajax: {
                  url: "<?= site_url('origin/get_ajax_data') ?>",
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
              placeholder: 'Select Origin',
          });

          $("[name='id_warehouse']").select2({
              ajax: {
                  url: "<?= site_url('warehouse/get_ajax_data_select') ?>",
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
              placeholder: 'Select Warehouse',
          });

          $('.btn-add-product').on('click', function() {
              var origin = $('#id_origin').val();
              var warehouse = $('#id_warehouse').val();
              origin = origin == null ? '' : origin;
              warehouse = warehouse == null ? '' : warehouse;

              if (origin == '' && warehouse == '') {
                  toastr.error('Select Warehouse First!')
              } else {
                  add_row();
                  lock_warehouse();
                  //init_select_locator();
              }
          })

          $('#table_product').on('click', '.btn-trash', function() {
              var index = $(this).parent().parent().index();
              var id_detail = $('[name="id_detail[]"]').eq(index).val();
              id_trash.push(id_detail);

              $(this).parent().parent().remove();
              var row = $('#table_product tbody tr').length;
              if (row == 0) {
                  unlock_warehouse();
              }
          })

          $(document).on('change', "[name='id_product[]']", function() {
              var index = $(this).parent().parent().index();
              var data = $(this).select2('data')[0];
              $("[name='uom_product[]']").eq(index).val(data['uom']).change();
          })

          $('#form_order').on('submit', function(e) {
              e.preventDefault();

              Swal.fire({
                  title: 'Do you want to save the changes?',
                  showCancelButton: true,
                  confirmButtonText: `Save`,
                  allowOutsideClick: false,
              }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                      //check table length
                      var row = $('#table_product tbody tr').length;
                      if (row == 0) {
                          Swal.fire('Please fill product table', '', 'info');
                      } else {
                          //save form
                          unlock_warehouse();
                          var formdata = new FormData($(this)[0]);
                          formdata.append('id_trash', id_trash);
                          save_form(formdata);
                      }
                  }
              })
          })

          if (mode == 'edit') {
              get_info(id);
          }
      })
  </script>