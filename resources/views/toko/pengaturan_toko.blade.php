@extends('toko.layouts.layout')

@section('title','Pengaturan')

@section('content')
<div class="card">
    <div class="card-body">
    <h1>Pengaturan</h1>
        <!-- Nav tabs, ini tombol tab di atas -->
        <ul class="nav nav-tabs">
        <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
        <li class="active"><a href="#akun" data-toggle="tab">Akun</a></li> <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
        <li><a href="#profile" data-toggle="tab">Profile</a></li>
        <li><a href="#messages" data-toggle="tab">Messages</a></li>
        <li><a href="#settings" data-toggle="tab">Settings</a></li>
        </ul>
        <!-- Tab panes, ini content dari tab di atas -->
        <div class="tab-content">
        <div class="tab-pane active" id="akun">Selamat datang</div><!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
        <div class="tab-pane" id="profile">Profil saya</div>
        <div class="tab-pane" id="messages">Sangat Mudah membuat Tap dengan Bootstrap<img src="/img/emoticon/smile.gif"></div>
        <div class="tab-pane" id="settings">Setting di sini..</div>
        </div>  
    </div>
</div>


@endsection

@section('scriptcss')
   
@endsection

@section('scriptjs')

@endsection
