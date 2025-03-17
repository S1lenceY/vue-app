<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\sinprogramar;

class SinProgramarExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        sinprogramar::create([
            'id_poliza' => 1005, // Nuevo campo agregado
            'poliza' => '666',
            'cultivo' => 'PERRICHOLI',
            'contratante' => 'RUC: 12345678901',
            'asegurado' => 'DNI: 32323232',
            'departamento' => 'HUANCAVELICA',
            'provincia' => 'TAYACAJA',
            'distrito' => 'ÑAHUIMPUQUIO',
            'direccion' => '-5.316914 -95.080228',
            'tipo_evento' => 'TEMPERATURA BAJA',
            'inspector' => 'David Alejandro',
            'user_id' => 1
        ]);

    }
}
