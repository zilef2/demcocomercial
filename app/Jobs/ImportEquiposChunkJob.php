<?php

namespace App\Jobs;

use App\Models\Equipo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportEquiposChunkJob implements ShouldQueue
{
	//php artisan queue:work --queue=default --daemon --sleep=1 --tries=3 --max-jobs=100

  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $chunkData;

    public function __construct(array $chunkData)
    {
        $this->chunkData = $chunkData;
    }

    public function handle()
    {
        try {
//            $this->valoresProvedores = new ProveedoresImport();

        } catch (\Throwable $e) {
            Log::error('Error en fila: - ' . $e->getMessage());
        }
    }
}
