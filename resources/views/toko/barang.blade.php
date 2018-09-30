@extends('toko.layouts.layout')

@section('title','Dashboard')

@section('content')

<div class="content">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row sm-6">
                    <div class="row sm-6">
                        <h1 class="m-0 text-dark">Manajemen Barang</h1>
                    </div>
                </div>
                <div class="row sm-6">
                    <div class="row sm-6">
                        <button 
                            type="button" 
                            class="btn btn-primary btn-lg" 
                            data-toggle="modal" 
                            data-target="#favoritesModal">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
​
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-header">
                        <h3 class="box-title">List Barang</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="tblBarang" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stock Master</th>
                                        <th>Harga</th>
                                        <th>Satuan</th>
                                        <th>Descripsi</th>
                                        <th>Foto</th>
                                        <th>Nama Toko</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>      
            </div>
        </section>
    </div>

 <!-- jQuery 3 -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
    var  oTable;   
    $(document).ready(function() {
        oTable = $('#tblBarang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("lisBarang") }}'
            },
            columns: [
                {data: 'nama_barang', name: 'nama_barang'},
                {data: 'stock', name: 'stock'},
                {data: 'harga', name: 'harga'},
                {data: 'satuan', name: 'satuan'},
                {data: 'description', name: 'description'},
                {data: 'foto', name: 'foto'},
                {data: 'nama_toko', name: 'nama_toko'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });
    });

    </script>  

@endsection


@section('scriptcss')

@endsection

@section('scriptjs')

@endsection
