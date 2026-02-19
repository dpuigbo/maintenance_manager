<?php

namespace Database\Seeders;

use App\Models\Aceite;
use App\Models\Cliente;
use App\Models\ComponenteSistema;
use App\Models\Consumible;
use App\Models\Fabricante;
use App\Models\Informe;
use App\Models\Intervencion;
use App\Models\Maquina;
use App\Models\ModeloComponente;
use App\Models\Planta;
use App\Models\Sistema;
use App\Models\User;
use App\Models\VersionTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin PAS',
            'email' => 'admin@pasrobotics.com',
            'password' => bcrypt('password'),
        ]);

        // Fabricantes
        $abb = Fabricante::create(['nombre' => 'ABB', 'orden' => 1]);
        $kuka = Fabricante::create(['nombre' => 'KUKA', 'orden' => 2]);
        $fanuc = Fabricante::create(['nombre' => 'FANUC', 'orden' => 3]);
        $yaskawa = Fabricante::create(['nombre' => 'Yaskawa', 'orden' => 4]);

        // Modelos componente ABB
        $irc5 = ModeloComponente::create([
            'fabricante_id' => $abb->id, 'tipo' => 'controller', 'nombre' => 'IRC5',
        ]);
        $irb6700 = ModeloComponente::create([
            'fabricante_id' => $abb->id, 'tipo' => 'mechanical_unit', 'nombre' => 'IRB 6700',
        ]);
        $irb2600 = ModeloComponente::create([
            'fabricante_id' => $abb->id, 'tipo' => 'mechanical_unit', 'nombre' => 'IRB 2600',
        ]);
        $duAbb = ModeloComponente::create([
            'fabricante_id' => $abb->id, 'tipo' => 'drive_unit', 'nombre' => 'DSQC 1000',
        ]);

        // Modelos componente KUKA
        $krc4 = ModeloComponente::create([
            'fabricante_id' => $kuka->id, 'tipo' => 'controller', 'nombre' => 'KRC4',
        ]);
        $kr210 = ModeloComponente::create([
            'fabricante_id' => $kuka->id, 'tipo' => 'mechanical_unit', 'nombre' => 'KR 210',
        ]);

        // Modelos componente FANUC
        $r30ib = ModeloComponente::create([
            'fabricante_id' => $fanuc->id, 'tipo' => 'controller', 'nombre' => 'R-30iB Plus',
        ]);
        $m20ia = ModeloComponente::create([
            'fabricante_id' => $fanuc->id, 'tipo' => 'mechanical_unit', 'nombre' => 'M-20iA',
        ]);

        // Versiones template (esquemas básicos)
        $basicSchema = [
            'blocks' => [
                ['id' => Str::uuid()->toString(), 'type' => 'header', 'config' => [
                    'title' => 'Informe de Mantenimiento', 'subtitle' => '', 'showLogo' => true,
                    'showDate' => true, 'showReference' => true, 'logoPosition' => 'left', 'logoUrl' => '',
                ]],
                ['id' => Str::uuid()->toString(), 'type' => 'section_title', 'config' => [
                    'title' => 'Inspección General', 'description' => '', 'level' => 1, 'color' => '#3b82f6',
                ]],
                ['id' => Str::uuid()->toString(), 'type' => 'tristate', 'config' => [
                    'key' => 'estado_general', 'label' => 'Estado general del equipo',
                    'withObservation' => true, 'required' => true, 'maintenanceLevel' => 'general',
                ]],
            ],
            'pageConfig' => [
                'orientation' => 'portrait',
                'margins' => ['top' => 20, 'right' => 15, 'bottom' => 20, 'left' => 15],
                'fontSize' => 10,
            ],
        ];

        foreach ([$irc5, $irb6700, $irb2600, $duAbb, $krc4, $kr210, $r30ib, $m20ia] as $modelo) {
            VersionTemplate::create([
                'modelo_componente_id' => $modelo->id,
                'version' => 1,
                'estado' => 'activo',
                'schema' => $basicSchema,
                'created_by' => $user->id,
            ]);
        }

        // Clientes
        $clientes = [
            ['nombre' => 'SEAT S.A.', 'sede' => 'Barcelona'],
            ['nombre' => 'Volkswagen Navarra', 'sede' => 'Pamplona'],
            ['nombre' => 'Mercedes-Benz España', 'sede' => 'Vitoria'],
            ['nombre' => 'Gestamp Automoción', 'sede' => 'Bilbao'],
            ['nombre' => 'Grupo Antolin', 'sede' => 'Burgos'],
        ];

        foreach ($clientes as $i => $c) {
            $cliente = Cliente::create(array_merge($c, [
                'tarifa_hora_trabajo' => rand(45, 85),
                'tarifa_hora_viaje' => rand(30, 55),
                'dietas' => rand(15, 35),
                'precio_km' => 0.35,
            ]));

            // Plantas
            $plantaNames = ['Planta Principal', 'Planta Norte', 'Planta Pintura'];
            $numPlantas = rand(1, 3);

            for ($p = 0; $p < $numPlantas; $p++) {
                $planta = Planta::create([
                    'cliente_id' => $cliente->id,
                    'nombre' => $plantaNames[$p],
                    'direccion' => 'Polígono Industrial, nave ' . ($p + 1),
                    'ciudad' => $c['sede'],
                ]);

                // Máquinas
                $numMaquinas = rand(1, 3);
                for ($m = 0; $m < $numMaquinas; $m++) {
                    $maquina = Maquina::create([
                        'cliente_id' => $cliente->id,
                        'planta_id' => $planta->id,
                        'nombre' => 'Línea ' . ($m + 1),
                    ]);

                    // Sistemas
                    $fabricante = [$abb, $kuka, $fanuc][array_rand([$abb, $kuka, $fanuc])];
                    $sistema = Sistema::create([
                        'cliente_id' => $cliente->id,
                        'planta_id' => $planta->id,
                        'maquina_id' => $maquina->id,
                        'fabricante_id' => $fabricante->id,
                        'nombre' => 'Robot-' . strtoupper(Str::random(4)),
                    ]);

                    // Componentes del sistema
                    $controllerModel = $fabricante->id === $abb->id ? $irc5 :
                        ($fabricante->id === $kuka->id ? $krc4 : $r30ib);
                    $muModel = $fabricante->id === $abb->id ? $irb6700 :
                        ($fabricante->id === $kuka->id ? $kr210 : $m20ia);

                    ComponenteSistema::create([
                        'sistema_id' => $sistema->id, 'tipo' => 'controller',
                        'modelo_componente_id' => $controllerModel->id,
                        'etiqueta' => $controllerModel->nombre, 'numero_ejes' => 0, 'orden' => 0,
                    ]);
                    ComponenteSistema::create([
                        'sistema_id' => $sistema->id, 'tipo' => 'mechanical_unit',
                        'modelo_componente_id' => $muModel->id,
                        'etiqueta' => $muModel->nombre, 'numero_ejes' => 6, 'orden' => 1,
                    ]);
                }
            }

            // Intervenciones
            $tipos = ['preventiva', 'correctiva'];
            $estados = ['borrador', 'en_curso', 'completada', 'facturada'];
            $numIntervenciones = rand(2, 5);

            for ($iv = 0; $iv < $numIntervenciones; $iv++) {
                $estado = $estados[array_rand($estados)];
                $intervencion = Intervencion::create([
                    'cliente_id' => $cliente->id,
                    'tipo' => $tipos[array_rand($tipos)],
                    'estado' => $estado,
                    'referencia' => 'INT-' . date('Y') . '-' . str_pad(($i * 10 + $iv + 1), 4, '0', STR_PAD_LEFT),
                    'titulo' => ($iv % 2 === 0 ? 'Mantenimiento preventivo' : 'Correctivo') . ' ' . $c['nombre'],
                    'fecha_inicio' => now()->subDays(rand(1, 90)),
                    'fecha_fin' => $estado === 'completada' || $estado === 'facturada' ? now()->subDays(rand(0, 30)) : null,
                    'created_by' => $user->id,
                ]);

                $sistemas = $cliente->sistemas()->inRandomOrder()->take(rand(1, 2))->get();
                $intervencion->sistemas()->attach($sistemas->pluck('id'));

                foreach ($sistemas as $sistema) {
                    Informe::create([
                        'intervencion_id' => $intervencion->id,
                        'sistema_id' => $sistema->id,
                        'estado' => $estado === 'completada' || $estado === 'facturada' ? 'finalizado' : 'borrador',
                        'fecha_realizacion' => $estado === 'completada' ? now()->subDays(rand(0, 15)) : null,
                        'created_by' => $user->id,
                    ]);
                }
            }
        }

        // Catálogos
        Aceite::create(['nombre' => 'Optigear Synthetic X 320', 'fabricante' => 'Castrol', 'coste' => 45.00, 'precio' => 65.00]);
        Aceite::create(['nombre' => 'Mobilgear 600 XP 320', 'fabricante' => 'Mobil', 'coste' => 42.00, 'precio' => 60.00]);
        Aceite::create(['nombre' => 'Klübersynth GH 6-220', 'fabricante' => 'Klüber', 'coste' => 55.00, 'precio' => 78.00]);

        Consumible::create(['nombre' => 'Filtro de aire controladora', 'fabricante' => 'ABB', 'coste' => 12.00, 'precio' => 25.00]);
        Consumible::create(['nombre' => 'Batería de backup SMB', 'fabricante' => 'ABB', 'coste' => 85.00, 'precio' => 145.00]);
        Consumible::create(['nombre' => 'Ventilador axial controladora', 'fabricante' => 'Varios', 'coste' => 35.00, 'precio' => 65.00]);
    }
}
