<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reporte extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'id',
        'fecha',
        'hora_inicial',
        'hora_final',
        'tiempo_transcurrido',
        'actividad_id',
        'centrotrabajo_id',
        'ordentrabajo_id',
        'disponibilidad_id',
        'reproceso_id',
        'operario_id',
        'tipoFinalizacion', //BOUNDED 1: primera del dia | 2:intermedia | 3:Ultima del dia
        'tipoReporte', //acti, repro,disponibilidad
        'numero_oferta',
        'OTItem',
        'TiempoEstimado',
    ];
//    protected $appends = ['cd_ot'];
//    
//    public function getcd_otAttribute(): string {
//        $cdot = $this->orden2;
//        //todo: cambiar los id
//        if($this->centrotrabajo_id == 12){//oferta
//            $result = $cdot->cd;
//        }else{
//            $result = $cdot->nombre;//ot
//        }
//        return $result;
//    }

    // public function reportes() { return $this->hasMany('App\Models\Reporte'); }

    public function actividad(): BelongsTo { return $this->BelongsTo(Actividad::class); }
    public function centrotrabajo(): BelongsTo { return $this->BelongsTo(Centrotrabajo::class,'centrotrabajo_id'); }
    // public function material(): BelongsTo { return $this->BelongsTo(Material::class, 'material_id'); }
    public function orden2(): BelongsTo { return $this->BelongsTo(Ordentrabajo2::class,'ordentrabajo_id'); }
    public function operario(): BelongsTo { return $this->BelongsTo(User::class, 'operario_id'); }


    public function disponibilidad(): BelongsTo { return $this->BelongsTo(Disponibilidad::class,'disponibilidad_id'); }
    public function reproceso(): BelongsTo { return $this->BelongsTo(Reproceso::class); }


    public function HorFinal() : void{
        if($this->hora_final){
            $horaFinal = Carbon::parse($this->hora_final);
            $horaInicial = Carbon::parse($this->hora_inicial);
            $tiemtras = number_format($horaFinal->diffInSeconds($horaInicial)/60,3);
            $repor = [
                'tiempo_transcurrido' => $tiemtras
            ];
            $this->update($repor);
        }
    }

    public function HorFinalNoValidacion($horaFinal) : void{
        $horaFinal = Carbon::parse($this->hora_final);
        $horaInicial = Carbon::parse($this->hora_inicial);
        $tiemtras = number_format($horaFinal->diffInSeconds($horaInicial)/60,3);//minutos
        $repor = [
            'hora_final' => $horaFinal,
            'tiempo_transcurrido' => $tiemtras
        ];
        $this->update($repor);
    }

}
