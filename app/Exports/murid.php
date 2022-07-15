<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use App\Models\Kelase;
use Illuminate\Support\Collection;

class murid implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::where('kelase_id','=',auth()->user()->kelase_id)->where('level','=','user')->orderBy('name', 'asc')->get();
        $collect = collect([]);
        $nomer = 1;
        $collect->push(['nomer'=>'Nomer', 'user_id'=>'User_id', 'name'=>'Nama', 'level'=>'Level']);
        foreach($users as $user){
            $collect->push(['nomer'=>$nomer, 'user_id'=>$user->user_id, 'name'=>$user->name, 'level'=>$user->level]);
            $nomer++;
        }
        return $collect;
    }
}
