@extends('layout.popups')
@section('content')
<script>
    var existingProducts = [];

    @foreach ($sale->details as $product)
        @php
            $productID = $product->productID;
        @endphp
        existingProducts.push({{$productID}});
    @endforeach
</script>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" id="demo">
                <div class="row">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6"><h3> Edit Stock Out </h3></div>
                            <div class="col-6 d-flex flex-row-reverse"><button onclick="window.close()" class="btn btn-danger">Close</button></div>
                        </div>
                    </div>
                </div>
           
            <div class="card-body">
                <form action="{{ route('sale.update', $sale->id) }}" method="post">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select name="product" class="selectize" id="product">
                                        <option value=""></option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{$product->code}} - {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th width="20%">Product</th>
                                        <th class="text-center">Warehouse</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Qty</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="products_list">
                                        @foreach ($sale->details as $product)
                                        @php
                                            $id = $product->product->id;
                                        @endphp
                                        <tr id="row_{{$id}}">
                                            <td class="no-padding">{{$product->product->name}}</td>
                                            <td class="no-padding"><select name="warehouse[]" class="form-control text-center no-padding" id="warehouse_{{$id}}">
                                                @foreach ($warehouses as $warehouse)
                                                    <option value="{{$warehouse->id}}" @selected($warehouse->id == $product->warehouseID)>{{$warehouse->name}}</option>
                                                @endforeach
                                            </select></td>
                                            <td class="no-padding"><input type="number" name="qty[]" required step="any" value="{{$product->qty}}" min="0" class="form-control text-center no-padding" id="qty_{{$id}}"></td>
                                           
                                            <td class="no-padding"> <span class="btn btn-sm btn-danger" onclick="deleteRow({{$id}})">X</span> </td>
                                            <input type="hidden" name="id[]" value="{{$id}}">
                                        </tr>
                                        @endforeach
                                    </tbody>
                                
                                </table>
                            </div>
                            <div class="col-3"></div>
                            <div class="col-3 mt-2">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" value="{{ $sale->date }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-3 mt-2">
                                <div class="form-group">
                                    <label for="customer">Salesman</label>
                                    <select name="customerID" id="customerID" class="selectize1">
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" @selected($customer->id == $sale->customerID)>{{ $customer->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group customerName mt-2">
                                    <label for="customerName">Name</label>
                                    <input type="text" name="customerName" value="{{$sale->customerName}}" id="customerName" class="form-control">
                                </div>
                            </div>


                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" cols="30" rows="5">{{$sale->notes}}</textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Update Vouchar</button>
                            </div>
                </div>
            </form>
            </div>
        </div><!--end row-->

        </div>
        <!--end card-->
    </div>
    <!--end col-->
    </div>
    <!--end row-->
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/selectize/selectize.min.css') }}">
    <style>
        .no-padding {
            padding: 5px 5px !important;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>
    <script>
        $(".selectize1").selectize();
        $(".selectize").selectize({
            onChange: function(value) {
                if (!value.length) return;
                if (value != null) {
                    getSingleProduct(value);
                    this.clear();
                    this.focus();
                }

            },
        });
        var warehouses = @json($warehouses);

        function getSingleProduct(id) {
            $.ajax({
                url: "{{ url('sales/getproduct/') }}/" + id,
                method: "GET",
                success: function(product) {
                    let found = $.grep(existingProducts, function(element) {
                        return element === product.id;
                    });
                    if (found.length > 0) {

                    } else {
                        var id = product.id;
                        var html = '<tr id="row_' + id + '">';
                        html += '<td class="no-padding">' + product.name + '</td>';
                        html += '<td class="no-padding"><select name="warehouse[]" class="form-control text-center no-padding" id="warehouse_' + id + '">';
                            warehouses.forEach(function(warehouse) {
                                html += '<option value="' + warehouse.id + '" >' + warehouse.name + '</option>';
                            });
                        html += '</select></td>';
                        html += '<td class="no-padding"><input type="number"  disabled value="'+product.stock+'" class="form-control text-center"></div></td>';
                        html += '<td class="no-padding"><input type="number" name="qty[]" oninput="updateChanges(' + id +')" min="0.1" required step="any" value="1" class="form-control text-center" id="qty_' + id + '"></div></td>';
                        html += '<td> <span class="btn btn-sm btn-danger" onclick="deleteRow('+id+')">X</span> </td>';
                        html += '<input type="hidden" name="id[]" value="' + id + '">';
                        html += '<input type="hidden" id="stock_'+id+'" value="' + product.stock + '">';
                        html += '</tr>';
                        $("#products_list").prepend(html);
                        updateChanges(id);
                        existingProducts.push(id);
                    }
                }
            });
        }

        function updateChanges(id) {
            var qty = $('#qty_' + id).val();
            var price = $('#price_' + id).val();

            var amount = price * qty;

            $("#amount_"+id).val(amount);

            updateTotal();
        }

        updateTotal();

        function updateTotal() {


            var totalAmount = 0;
            $("input[id^='amount_']").each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $(this).val();
                totalAmount += parseFloat(inputValue);
            });
            $("#totalAmount").html(totalAmount.toFixed(2));

            var discount = parseFloat($("#discount").val());
            var dc = parseFloat($("#dc").val());

            var net = (totalAmount + dc) - discount;

            $("#net").val(net);

        }

        function deleteRow(id) {
            existingProducts = $.grep(existingProducts, function(value) {
                return value !== id;
            });
            $('#row_'+id).remove();
            updateTotal();
        }

        function checkAccount()
    {
        var id = $("#customerID").find(":selected").val();
        if(id == 1)
        {
            $(".customerName").removeClass("d-none");
           
        }
        else
        {
            $(".customerName").addClass("d-none");
          
        }
    }

    $("#customerID").on("change", function(){
        checkAccount();
    });
    checkAccount();


    </script>
@endsection
