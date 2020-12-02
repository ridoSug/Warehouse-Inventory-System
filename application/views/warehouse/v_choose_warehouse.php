  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Warehouse</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Warehouse</a></li>
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
                              Manage Data Warehouse
                          </div>
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-12">
                                      <table class="table" id="table_warehouse">
                                          <thead>
                                              <tr>
                                                  <th>Name</th>
                                                  <th>Address</th>
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
  </div>
  <script>
      $(document).ready(function() {
          var mode = 'add';

          var table = $('#table_warehouse').DataTable({
              ajax: {
                  url: "<?= site_url('warehouse/get_ajax_data_warehouse') ?>",
                  type: 'POST'
              },
              order: [],
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
              columns: [{
                      data: 'name',
                      width: '350px'
                  },
                  {
                      data: 'address'
                  },
                  {
                      data: 'id',
                      width: '150px',
                      render: function(data, type, row) {
                          var btn = '<button type="button" class="btn btn-primary btn-choose mr-1 mb-1"><i class="fa fa-upload"></i></button>';
                          return btn;
                      }
                  }
              ]
          })


          $('#table_warehouse').on('click', '.btn-choose', function() {
              var row = table.row($(this).parent().parent()).data();
              var tipe = "<?= $tipe ?>";
              var url = "<?= site_url('warehouse/') ?>" + tipe + '/'
              window.location.href = url + row['md5_id'];
          })

      })
  </script>