<?php

namespace App\Exports;

use App\Models\Nilai;
use App\Models\Ujian;
use Maatwebsite\Excel\Concerns\FromCollection;

class ujianExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($code){
        $this->code = $code;
    }
    public function collection()
    {
        $ujian = Ujian::where('code','=',$this->code)->first();
        $nilais = Nilai::where('ujian_id','=',$ujian->id)->get();
        $collect = collect([]);
        $count = 0;
        $collect->push(['nomer'=>'Nomer', 'user'=>'Nama', 'nilai'=>'Nilai', 'type'=>'Tipe']);
        foreach ($nilais as $nilai) {
            ++$count;
            if ($nilai->nilai == null) {
                $nilai->nilai = 0;
            }
            if ($nilai->type == null) {
                $nilai->type = '-';
            }
            $collect->push(['nomer'=>$count, 'user'=>$nilai->user->name, 'nilai'=>$nilai->nilai, 'type'=>$nilai->type]);
            
        }
        return $collect;
    }
}
