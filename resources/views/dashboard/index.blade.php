@extends('layout.app')
@section('content')

<div class="row">
       <div class="col-12">
              <div class="card">
                     <div class="card-header">
                            <h3>Low Stock Products</h3>
                     </div>
                     <div class="card-body">
                            <table class="table table-bordered" id="buttons-datatables">
                                 <thead>
                                   <th>#</th>
                                   <th>Code</th>
                                   <th>Product</th>
                                   <th>Brand</th>
                                   <th>Alert</th>
                                   <th>Current Stock</th>
                                 </thead>
                                 <tbody>
                                   @php
                                          $ser = 0;
                                   @endphp
                                   @foreach ($products as $key => $product)
                                   @if ($product->alert > 0 && $product->stock <= $product->alert)
                                   @php
                                          $ser++;
                                   @endphp
                                   <tr>
                                          <td>{{$ser}}</td>
                                          <td>{{$product->code}}</td>
                                          <td>{{$product->name}}</td>
                                          <td>{{$product->category->name}}</td>
                                          <td>{{$product->alert}}</td>
                                          <td>{{$product->stock}}</td>
                                      </tr>
                                   @endif
                                   @endforeach
                                 </tbody>
                            </table>
                     </div>
              </div>
       </div>
</div>
@endsection
@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable.bootstrap5.min.css') }}" />
<!--datatable responsive css-->
<link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.dataTables.min.css') }}">
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/vfs_fonts.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/pdfmake.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/jszip.min.js')}}"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection


