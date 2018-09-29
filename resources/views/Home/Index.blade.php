<table>
    <tr>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Telepon</th>
    </tr>
    @foreach ($list as $awe)
        <tr>
            <td>$awe->akang</td>
        </tr>
    @endforeach
</table>