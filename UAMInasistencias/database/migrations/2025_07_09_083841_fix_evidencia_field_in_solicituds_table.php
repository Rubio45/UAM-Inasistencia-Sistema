<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero, convertir los datos existentes a JSON
        $solicitudes = DB::table('solicituds')->get();
        
        foreach ($solicitudes as $solicitud) {
            if ($solicitud->evidencia) {
                // Convertir string a array JSON
                DB::table('solicituds')
                    ->where('id', $solicitud->id)
                    ->update(['evidencia' => json_encode([$solicitud->evidencia])]);
            } else {
                // Si no hay evidencia, establecer como array vacío
                DB::table('solicituds')
                    ->where('id', $solicitud->id)
                    ->update(['evidencia' => json_encode([])]);
            }
        }

        // Ahora cambiar el tipo de columna
        Schema::table('solicituds', function (Blueprint $table) {
            $table->json('evidencia')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convertir de vuelta a string (tomar el primer elemento del array)
        $solicitudes = DB::table('solicituds')->get();
        
        foreach ($solicitudes as $solicitud) {
            $evidencias = json_decode($solicitud->evidencia, true);
            $primeraEvidencia = is_array($evidencias) && count($evidencias) > 0 ? $evidencias[0] : null;
            
            DB::table('solicituds')
                ->where('id', $solicitud->id)
                ->update(['evidencia' => $primeraEvidencia]);
        }

        Schema::table('solicituds', function (Blueprint $table) {
            $table->string('evidencia')->nullable()->change();
        });
    }
};
