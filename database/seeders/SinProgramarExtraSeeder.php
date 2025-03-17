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
            'id_poliza' => 1003, // Nuevo campo agregado
            'poliza' => '10357889302',
            'cultivo' => 'PAPA//CANCHAN/UNICA/YUNGAY/PERRICHOLI',
            'contratante' => 'RUC: 12345678901 - agrobanco',
            'asegurado' => 'DNI: 70302287 - ARROYO MENDEZ GIMI BRIAN',
            'departamento' => 'HUANCAVELICA',
            'provincia' => 'TAYACAJA',
            'distrito' => 'ÑAHUIMPUQUIO',
            'direccion' => 'CP IMPERIAL; -12.316914 -75.080228',
            'tipo_evento' => 'TEMPERATURA BAJA',
            'inspector' => 'Cristian Arotoma Arroyo',
            'user_id' => 1
        ]);

        sinprogramar::create([
            'id_poliza' => 1004, // Nuevo campo agregado
            'poliza' => '10358566655',
            'cultivo' => 'PAPA//AMARILLA/PERUANITA/HUAYRO',
            'contratante' => 'RUC: 12345678901 - agrobanco',
            'asegurado' => 'DNI: 19839190 - TORRES SOTO SEVERO CESAR',
            'departamento' => 'HUANCAVELICA',
            'provincia' => 'TAYACAJA',
            'distrito' => 'PAZOS',
            'direccion' => 'CP.CHUQUITAMBO; -12.269077 -75.085346',
            'tipo_evento' => 'GRANIZO',
            'inspector' => 'Cristian Arotoma Arroyo',
            'user_id' => 1
        ]);

        sinprogramar::create([
            'id_poliza' => 1005, // Nuevo campo agregado
            'poliza' => '10358751835',
            'cultivo' => 'PAPA//CANCHAN/UNICA/YUNGAY/PERRICHOLI',
            'contratante' => 'RUC: 12345678901 - agrobanco',
            'asegurado' => 'DNI: 44096550 - SANCHEZ GARFIAS DANIEL',
            'departamento' => 'APURIMAC',
            'provincia' => 'ANDAHUAYLAS',
            'distrito' => 'PACUCHA',
            'direccion' => 'COMUNIDAD DE ARGAMA ALTA; -13.637863 -73.283912',
            'tipo_evento' => 'GRANIZO',
            'inspector' => 'Jose Luis Año Kari',
            'user_id' => 1
        ]);

    }
}
