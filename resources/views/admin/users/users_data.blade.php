@isset($users)
    @foreach($users as $key=>$value)
        <tr>
            <td class="text-center">{{$sl_counter++}}</td>
            <td >{{$value->name}}</td>
            <td >{{$value->phone}}</td>
            <td >{{$value->email}}</td>
            <td >{{($value->status==1)?"Approved":(($value->status==2)?"Pending":"New")}}</td>
            <td class="text-center" >
                <a  href="{{url("admin/user-edit/".$value->id)}}"  class="text-info btn btn-info btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit" id=""><i class="fa fa-edit"></i></a>
                <a onclick="return confirm('Are You Sure?')" href="{{url("admin/control/".$value->id)}}" title="{{($value->status==1)?"Approved":(($value->status==2)?"Pending":"New")}}" class="btn btn-{{($value->status==1)?"success":(($value->status==2)?"danger":"primary")}}   btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-check-circle"></i></a>
            </td>
        </tr>
    @endforeach
     <tr>
        <td colspan="6" class="text-center">{{$users->links()}}</td>
    </tr>
@endisset
