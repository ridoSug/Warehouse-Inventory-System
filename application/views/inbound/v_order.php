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
                                                  <select name="id_origin" id="id_origin" class="form-control select2" required></select>
                                              </div>
                                              <div class="col-md-3">
                                                  <label>Warehouse Destination</label>
                                                  <select name="id_warehouse" id="id_warehouse" class="form-control select2" required></select>
                                              </div>
                                              <div class="col-md-3">
                                                  <label>Creator</label>
                                                  <input type="hidden" name="id_user_created">
                                                  <input type="text" name="name-creator" class="form-control-plaintext" readonly>
                                              </div>
                                          </div>
                                      </div>

                                      <!-- END ROW -->
                                  </div>
                              </div>
                              <div class="card-body">
                                  <table class="table" id="table_product">
                                      <thead>
                                          <tr>
                                              <th>Product Name</th>
                                              <th>Unit</th>
                                              <th>Site Id</th>
                                              <th>Site Name</th>
                                              <th>Qty</th>
                                              <th>Locator</th>
                                              <th></th>
                                          </tr>
                                      </thead>
                                      <tbody></tbody>
                                  </table>
                              </div>
                              <div class="card-footer">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <button type="button" class="btn btn-primary btn-add-product">
                                              <i class="fa fa-plus"> </i> Add Rows
                                          </button>
                                          <div class="pull-right">

                                              <button type="submit" class="btn btn-success btn-save">
                                                  <i class="fa fa-save"> </i> Save
                                              </button>
                                          </div>
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

          if (id == '') {
              $('[name=id_user_created]').val(id_karyawan);
              $('[name=name-creator]').val(nama_karyawan);
          } else {

          }

          //select2


          function add_row() {
              var _tr = '<tr>';
              _tr += '<td><select style="width:400px" name="id_product[]" class="form-control select2" required></select></td>';
              _tr += '<td><input name="uom_product[]" class="form-control-plaintext" readonly></td>';
              _tr += '<td><input name="site_id[]" class="form-control" required></td>';
              _tr += '<td><input name="site_name[]" class="form-control" required></td>';
              _tr += '<td><input style="width:140px" type="number" step="0.01" name="qty[]" class="form-control" required></td>';
              _tr += '<td><select name="id_locator[]" class="form-control select2" required></select></td>';
              _tr += `<td>
              <input type="hidden" name="id_detail[]" value="0">
              <button type="button" class="btn btn-danger btn-trash"><i class="fa fa-trash"></i></button>
              </td>`;
              _tr += '</tr>';

              $('#table_product tbody').append(_tr);

              $('.select2').select2();
          }

          $('.btn-add-product').on('click', function() {
              var origin = $('#id_origin').val();
              var warehouse = $('#id_warehouse').val();
              origin = origin == null ? '' : origin;
              warehouse = warehouse == null ? '' : warehouse;
              console.log(origin);
              console.log(warehouse);
              if (origin == '' && warehouse == '') {
                  toastr.danger('Select Warehouse First!')
              } else {
                  add_row();
              }
          })

      })
  </script>