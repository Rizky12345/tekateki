@extends('../layout/head_link2')

@section('body_link')
<a href="{{ url('admin/murid/excel') }}">
    <button class="button is-info">Excel</button>
</a>
<br><br>
<div class="card">
    <div class="card-header">
        <div class="card-header-title">
            Murid {{ auth()->user()->kelase->kelas }}
        </div>
    </div>
    <div class="card-content" style="overflow-x: auto;">
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>No</th>
                    <th>user_id</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ ++$nomer }}</td>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->kelase->kelas }}</td>
                    <td>
                        @if($user->level == 'user')
                        Murid
                        @elseif($user->level == 'admin')
                        Guru
                        @elseif($user->level == 'super admin')
                        Administrator
                        @endif
                    </td>
                    <td>
                        <div class="buttons is-right">
                            <a href="{{ url("admin/user/$user->user_id/$user->name") }}">
                                <button class="button is-small is-primary" type="button">
                                    <span class="icon"><i class="mdi mdi-eye"></i></span>
                                </button>
                            </a></div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection

