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
                            data-target="#modal-add">
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

<!-- set up the modal to start hidden and fade in and out -->
<div id="modal-add" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- dialog body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Tambah Barang
      </div>
      <div class="col-md-12">
            @if (session('error'))
                @alert(['type' => 'danger'])
                    {!! session('error') !!}
                @endalert
            @endif
​                    
            <form role="form" id="frm_barang" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" 
                    name="nama_barang"
                    class="form-control {{ $errors->has('nama_barang') ? 'is-invalid':'' }}" id="nama_barang" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="text" 
                    name="stock"
                    class="form-control {{ $errors->has('stock') ? 'is-invalid':'' }}" id="stock" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="text" 
                    name="harga"
                    class="form-control {{ $errors->has('harga') ? 'is-invalid':'' }}" id="harga" required>
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <select class="form-control satuan" name="satuan" id="satuanz" data-live-search="true">
                    <option value=''>Choose One</option><option data-tokens='Pcs' value='1'>Pcs</option><option data-tokens='Kardus' value='2'>Kardus</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" cols="5" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}"></textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" name="foto[]" id="foto" multiple="multiple" required>
                </div>
                <button type="submit" class="btn btn-primary" id="btnSave">OK</button>
            </form>   
        </div>
      <!-- dialog buttons -->
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<!--MODAL EDIT-->
<div id="edit-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- dialog body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Tambah Barang
      </div>
      <div class="col-md-12">
            @if (session('error'))
                @alert(['type' => 'danger'])
                    {!! session('error') !!}
                @endalert
            @endif
​                    
            <form role="form" id="frm_edit_barang" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" value="{{ csrf_token() }}" name="_tokenx"/>
                    <input type="hidden" id="id" name="id"/>
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" 
                    name="nama_barang_edit"
                    class="form-control {{ $errors->has('nama_barang') ? 'is-invalid':'' }}" id="nama_barang_edit" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="text" 
                    name="stock_edit"
                    class="form-control {{ $errors->has('stock') ? 'is-invalid':'' }}" id="stock_edit" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="text" 
                    name="harga_edit"
                    class="form-control {{ $errors->has('harga') ? 'is-invalid':'' }}" id="harga_edit" required>
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <select class="form-control satuanz" name="satuan_edit" id="satuanz_edit" data-live-search="true">
                    <!-- <option value=''>Choose One</option><option data-tokens='Pcs' value='1'>Pcs</option><option data-tokens='Kardus' value='2'>Kardus</option> -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description_edit" id="description_edit" cols="5" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}"></textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <div id="galeri"></div>
                    <input type="file" class="form-control" name="foto[]" id="foto" multiple="multiple">
                </div>
                <button type="submit" class="btn btn-primary" id="btnSaveEdit">OK</button>
            </form>   
        </div>
      <!-- dialog buttons -->
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

 <!-- jQuery 3 -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">
    var  oTable;   
    $(document).ready(function() {
        $('.satuan').selectpicker();
        getSatuan();
        //getData(4);
        galery(4);
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

        $('#frm_barang').on('submit', function (e) {
            //alert("awe");
            e.preventDefault();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_token']").val()
            }
            });
            swal({
                title: "Are you sure Save?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((oke) => {
                if (oke) {
                
                    $.ajax({
                        type: "POST",
                        url: "{{route ('barangPost')}}",
                        data: new FormData(this),
                        contentType:false,
                        processData:false,
                        success: function(response) {
                            console.log(response);
                            if (response.status == 200){
                                swal(response.message, {
                                    icon: "success",
                                }).then(function(){
                                    oTable.ajax.reload();
                                    document.getElementById('btnSave').disabled=true;
                                });
                            }else{
                                swal(response.message, {
                                    icon: "error",
                                });
                            }
                        }
                    });
                    return true;
                } else {
                    swal("Cancel Save!");
                }
            });
        });

        $('#frm_edit_barang').on('submit', function (e) {
            //alert("awe");
            e.preventDefault();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_tokenx']").val()
            }
            });
            swal({
                title: "Are you sure Save?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((oke) => {
                if (oke) {
                
                    $.ajax({
                        type: "POST",
                        url: "{{route ('barangEdit')}}",
                        data: new FormData(this),
                        contentType:false,
                        processData:false,
                        success: function(response) {
                            console.log(response);
                            if (response.status == 200){
                                swal(response.message, {
                                    icon: "success",
                                }).then(function(){
                                    document.getElementById('btnSaveEdit').disabled=true;
                                    galery(response.kode);
                                    getData(response.kode);
                                    oTable.ajax.reload();
                                });
                            }else{
                                swal(response.message, {
                                    icon: "error",
                                });
                            }
                        }
                    });
                    return true;
                } else {
                    swal("Cancel Save!");
                }
            });
        });
    });

    // function getSatuan(){
    //     var id = $('#id').val();
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ url ('listSatuanEdit/') }}" +id,
    //         cache:false,
    //         success: function(response) {
    //             console.log(response);
    //             $("#satuanz_edit").html(response);
    //         }
    //     });
    // }

      function getSatuan(){
        $.ajax({
            type: "GET",
            url: "{{ route ('satuan') }}",
            cache:false,
            success: function(response) {
                console.log(response);
                $("#satuanz_edit").html(response);
            }
        });
    }

    // function detail(x){
    //     $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $("input[name='_token']").val()
    //             }
    //         });
    //     $.ajax({
    //         type: "POST",
    //         url: "{{ route('barangDetail') }}",
    //         data: {id:x},
    //         success: function(response) {
    //             console.log(response);
    //             // var myArr = response.split("|");
    //             // $("#kd_barang_edit").attr('disabled','disabled');
    //             // $("#kd_barang_edit").val(myArr[1]);
    //             // $("#nama_barang_edit").val(myArr[2]);
    //             // $("#description_edit").val(myArr[3]);
    //             // $("#stock_edit").val(myArr[4]);
    //             // $("#foto_edit").val(myArr[7]);

    //             // $("#kategori_edit").append("<option value='"+myArr[5]+"'>"+myArr[6]+"</option>"); 
    //         }
    //     });
    //     return true;
    // }

    function getData(x){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_tokenx']").val()
                }
            });
        $.ajax({
            type: "POST",
            url: "{{ route('barangDetail') }}",
            data: {id:x},
            success: function(response) {
                console.log(response);
                if(response){
                    var myArr = response.split("|");
                    $("#id").val(myArr[0]);
                    $("#nama_barang_edit").val(myArr[1]);
                    $("#stock_edit").val(myArr[2]);
                    $("#harga_edit").val(myArr[3]);
                    $("#description_edit").val(myArr[4]);
                    galery(myArr[0]);
                }else{
                    swal("Gak Ada Data", {
                        icon: "error",
                    });
                }
            }
        });
        return true;
    }

    function galery(y){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_tokenx']").val()
                }
            });
        $.ajax({
            type: "POST",
            url: "{{ route('galery') }}",
            data: {id:y},
            success: function(response) {
                console.log(response);
                $("#galeri").html(response);
            }
        });
    }

    function delFoto(z){
        //z.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_tokenx']").val()
            }
        });      

        swal({
            title: "Are you sure Save?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((oke) => {
            if (oke) {
            
                $.ajax({
                    type: "POST",
                    url: "{{ route ('hapusFoto') }}",
                    data: {id:z},
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200){
                            swal(response.message, {
                                icon: "success",
                            }).then(function(){
                                galery(response.kode);
                            });
                        }
                    }
                });
            return true;
            } else {
                swal("Cancel Save!");
            }
        });
    }
    function DeleteData(z){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_tokenx']").val()
            }
        });      

        swal({
            title: "Are you sure Delete This Data?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((oke) => {
            if (oke) {
            
                $.ajax({
                    type: "POST",
                    url: "{{ route ('hapusBarang') }}",
                    data: {id:z},
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200){
                            swal(response.message, {
                                icon: "success",
                            }).then(function(){
                                oTable.ajax.reload();
                            });
                        }
                    }
                });
            return true;
            } else {
                swal("Cancel Save!");
            }
        });
    }

</script>  

@endsection


@section('scriptcss')

@endsection

@section('scriptjs')

@endsection
