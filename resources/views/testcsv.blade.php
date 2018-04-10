<table>
    <tr>
        <th>ho</th>
        <th>te</th>
        <th>dc</th>
        <th>mk</th>
    </tr>
    @foreach($data as $item)
        <td>{{$item->ho}}</td>
        <td>{{$item->ten}}</td>
        <td>{{$item->dia_chi}}</td>
        <td>{{$item->mat_khau}}</td>
        @endforeach
</table>