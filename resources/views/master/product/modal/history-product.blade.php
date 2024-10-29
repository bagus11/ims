
<div class="modal fade" id="historyProductModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Track History Product
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 mx-2 mt-2">
                <input type="hidden" id="history_id">
                <input type="hidden" id="request_type">
                <div class="row mb-2">
                    <div class="col-2 offset-8">
                        <input type="date" id="from" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
                    </div>
                    <div class="col-2">
                        <input type="date" name="to" class="form-control" id="to"  value="{{date('Y-m-d')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                      <div class="card card-info card-tabs">
                        <div class="card-header p-0 pt-1 bg-core">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Request</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Purchase</a>
                            </li>
                          
                          </ul>
                        </div>
                        <div class="card-body p-0">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                <table class="datatable datatable-bordered" id="in_table" style="font-size:9px">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align:center;">Created At</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Request Code</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Item Name</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Location</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Destination Location</th>
                                            <th colspan="3" style="text-align:center; padding-left:10px;padding-right:10px">Quantity</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">UOM</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">PIC</th>
                                          
                                        </tr>
                                        <tr>
                                            <th>Before</th>
                                            <th>Request</th>
                                            <th>Current</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                <table class="datatable datatable-bordered" id="out_table" style="font-size:9px">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align:center;">Created At</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Request Code</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Item Name</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Location</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Destination Location</th>
                                            <th colspan="3" style="text-align:center; padding-left:10px;padding-right:10px">Quantity</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">UOM</th>
                                            <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">PIC</th>
                                          
                                        </tr>
                                        <tr>
                                            <th>Before</th>
                                            <th>Request</th>
                                            <th>Current</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        
                          </div>
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
               </div>
          
        </div>
    </div>
</div>