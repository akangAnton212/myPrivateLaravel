@extends('toko.layouts.layout')

@section('title','Buat Toko')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Buat Atau Edit Toko</h4>
        <p class="card-description">
        
        </p>
        <form class="forms-sample" role="form" id="frm_buka_toko" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
            <div class="form-group">
                <label for="namaToko">Nama Toko</label>
                <input type="text" class="form-control" id="namaToko" name="namaToko" placeholder="Nama Toko" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required></textarea>
            </div>
            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Telepon" required>
            </div>
            <div class="form-group">
                <label>File upload</label>
                <div class="input-group col-xs-12">
                    <input type="file" class="form-control" name="foto" id="foto">
                    <input type="text" class="form-control hidden" id="pathfoto" name="pathfoto">
                </div>
                <div id="files"></div>
            </div>
            <div class="form-group">
                <label for="jamBuka">Jam Buka</label>
                <input type="time" class="form-control" id="jamBuka" name="jamBuka" placeholder="Jam Buka" required>
            </div>
            <div class="form-group">
                <label for="jamTutup">Jam Buka</label>
                <input type="time" class="form-control" id="jamTutup" name="jamTutup" placeholder="Jam Tutup" required>
            </div>
            <button type="submit" class="btn btn-success mr-2" id="btnSave">Submit</button>
            <button class="btn btn-light">Cancel</button>
        </form>
    </div>
</div>

<!-- jQuery 3 -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        getData();
        $('#frm_buka_toko').on('submit', function (e) {
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
                        url: "{{ route ('buatToko') }}",
                        data: new FormData(this),
                        contentType:false,
                        processData:false,
                        success: function(response) {
                            console.log(response);
                            if (response.status == 200){
                                swal(response.message, {
                                    icon: "success",
                                }).then(function() {
                                    getData();
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

    function getData(){
        $("#files").empty();
        $.ajax({
            type: "GET",
            url: "{{ route('cekToko') }}",
            success: function(response) {
                console.log(response);
                var myArr = response.split("|");
                $("#namaToko").val(myArr[0]);
                $("#alamat").val(myArr[1]);
                $("#telepon").val(myArr[2]);
                $("#pathfoto").val(myArr[3]);
                $("#jamBuka").val(myArr[4]);
                $("#jamTutup").val(myArr[5]);

                if(myArr[3]!=''){
                    $("#files").append("<img src='../uploads/avatar_toko/"+myArr[3]+"')' 'height='60' width='60'>" ); 
                    $("#files").append("<input type='checkbox' name='cbgantifoto' id='cbganti' value ='1'> Ganti Foto?<br>" ); 
                }else{
                    $("#files").append("<input type='checkbox' name='cbgantifoto' id='cbganti' value ='0'> Ganti Foto?<br>" ); 
                }

                
                
            }
        });
        return true;
    }

  

  </script>

@endsection

@section('scriptcss')

@endsection

@section('scriptjs')

@endsection
