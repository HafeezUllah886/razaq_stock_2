@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Products Stock </h3>
                    <div class="col-3">
                        <select name="category" id="category" class="form-control" onchange="filterByCategory(this.value)">
                            <option value="0">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($category->id == $cat)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table" id="buttons-datatables">
                        <thead>
                            <th>#</th>
                            <th>Code</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock-In</th>
                            <th>Stock-Out</th>
                            <th>Avail Stock</th>
                            <th>Stock Value</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->pprice }}</td>
                                <td>{{ number_format(getStockCr($product->id), 2) }}</td>
                                <td>{{ number_format(getStockDb($product->id), 2) }}</td>
                                <td>{{ number_format(getStock($product->id), 2) }}</td>
                                <td>{{ number_format(productStockValue($product->id), 2) }}</td>
                                <td>
                                    <button class="btn btn-info" onclick="ViewDetails({{ $product->id }})">
                                        Details
                                    </button>
                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="viewDetailsModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">View Stock Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form method="get" target="" id="form">
                    @csrf
                    <input type="hidden" name="productID" id="productID">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Select Dates</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroup-sizing-default">From</span>
                                <input type="date" id="from" name="from" value="{{ firstDayOfMonth() }}"
                                    class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                                <span class="input-group-text" id="inputGroup-sizing-default">To</span>
                                <input type="date" id="to" name="to" value="{{ lastDayOfMonth() }}"
                                    class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="warehouse">Warehouse</label>
                            <select name="warehouse" class="form-control" id="warehouse">
                                <option value="all">All</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="viewBtn" class="btn btn-primary">View</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable.bootstrap5.min.css') }}" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.dataTables.min.css') }}">
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/jszip.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    <script>
        function ViewDetails(product) {
            $("#productID").val(product);
            $("#viewDetailsModal").modal('show');
        }

        $("#viewBtn").on("click", function() {
            var productID = $("#productID").val();
            var warehouse = $("#warehouse").find(":selected").val();
            var from = $("#from").val();
            var to = $("#to").val();
            var url =
                "{{ route('stockDetails', ['id' => ':productID', 'warehouse' => ':warehouse', 'from' => ':from', 'to' => ':to']) }}"
                .replace(':productID', productID)
                .replace(':warehouse', warehouse)
                .replace(':from', from)
                .replace(':to', to);
            window.open(url, "_blank", "width=1000,height=800");
        });

        function filterByCategory(category) {
            var url = "{{ route('product_stock.index') }}?category=" + category;
            window.location.href = url;
        }
    </script>
@endsection
