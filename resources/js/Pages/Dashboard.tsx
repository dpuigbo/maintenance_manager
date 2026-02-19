import AppLayout from '@/Layouts/AppLayout';
import { Head } from '@inertiajs/react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import {
    Users,
    Bot,
    ClipboardList,
    FileText,
    ArrowRight,
    Clock,
    AlertCircle,
} from 'lucide-react';
import { Button } from '@/Components/ui/button';
import { Link } from '@inertiajs/react';
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, Cell, PieChart, Pie } from 'recharts';
import type { DashboardStats, IntervencionReciente, EstadoChart, FabricanteChart } from '@/types';

interface Props {
    stats: DashboardStats;
    recientes: IntervencionReciente[];
    porEstado: EstadoChart[];
    fabricantes: FabricanteChart[];
}

const estadoColors: Record<string, string> = {
    borrador: 'bg-slate-100 text-slate-700',
    en_curso: 'bg-blue-100 text-blue-700',
    completada: 'bg-green-100 text-green-700',
    facturada: 'bg-purple-100 text-purple-700',
};

const estadoLabels: Record<string, string> = {
    borrador: 'Borrador',
    en_curso: 'En curso',
    completada: 'Completada',
    facturada: 'Facturada',
};

const tipoLabels: Record<string, string> = {
    preventiva: 'Preventiva',
    correctiva: 'Correctiva',
};

export default function Dashboard({ stats, recientes, porEstado, fabricantes }: Props) {
    const statCards = [
        {
            title: 'Clientes',
            value: stats.clientes,
            icon: Users,
            color: 'text-blue-600',
            bg: 'bg-blue-50',
        },
        {
            title: 'Sistemas',
            value: stats.sistemas,
            icon: Bot,
            color: 'text-emerald-600',
            bg: 'bg-emerald-50',
        },
        {
            title: 'Intervenciones',
            value: stats.intervenciones,
            icon: ClipboardList,
            color: 'text-amber-600',
            bg: 'bg-amber-50',
            subtitle: `${stats.intervenciones_en_curso} en curso`,
        },
        {
            title: 'Informes',
            value: stats.informes,
            icon: FileText,
            color: 'text-violet-600',
            bg: 'bg-violet-50',
            subtitle: `${stats.informes_pendientes} pendientes`,
        },
    ];

    return (
        <AppLayout>
            <Head title="Dashboard" />

            <div className="space-y-8">
                {/* Header */}
                <div>
                    <h1 className="text-2xl font-bold tracking-tight">Dashboard</h1>
                    <p className="text-muted-foreground">
                        Vista general del sistema de mantenimiento
                    </p>
                </div>

                {/* Stats cards */}
                <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    {statCards.map((stat) => (
                        <Card key={stat.title}>
                            <CardContent className="p-6">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">
                                            {stat.title}
                                        </p>
                                        <p className="text-3xl font-bold mt-1">{stat.value}</p>
                                        {stat.subtitle && (
                                            <p className="text-xs text-muted-foreground mt-1 flex items-center gap-1">
                                                <Clock className="h-3 w-3" />
                                                {stat.subtitle}
                                            </p>
                                        )}
                                    </div>
                                    <div className={`${stat.bg} p-3 rounded-xl`}>
                                        <stat.icon className={`h-6 w-6 ${stat.color}`} />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {/* Charts row */}
                <div className="grid gap-6 lg:grid-cols-2">
                    {/* Intervenciones por estado */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-base">Intervenciones por estado</CardTitle>
                            <CardDescription>Distribución actual</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[200px]">
                                <ResponsiveContainer width="100%" height="100%">
                                    <PieChart>
                                        <Pie
                                            data={porEstado.filter(d => d.value > 0)}
                                            cx="50%"
                                            cy="50%"
                                            innerRadius={50}
                                            outerRadius={80}
                                            paddingAngle={4}
                                            dataKey="value"
                                            nameKey="name"
                                        >
                                            {porEstado.filter(d => d.value > 0).map((entry, index) => (
                                                <Cell key={`cell-${index}`} fill={entry.color} />
                                            ))}
                                        </Pie>
                                        <Tooltip />
                                    </PieChart>
                                </ResponsiveContainer>
                            </div>
                            <div className="flex flex-wrap justify-center gap-4 mt-2">
                                {porEstado.map((item) => (
                                    <div key={item.name} className="flex items-center gap-2 text-sm">
                                        <div
                                            className="h-3 w-3 rounded-full"
                                            style={{ backgroundColor: item.color }}
                                        />
                                        <span className="text-muted-foreground">{item.name}</span>
                                        <span className="font-semibold">{item.value}</span>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Sistemas por fabricante */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-base">Sistemas por fabricante</CardTitle>
                            <CardDescription>Top fabricantes activos</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[250px]">
                                <ResponsiveContainer width="100%" height="100%">
                                    <BarChart data={fabricantes} layout="vertical" margin={{ left: 0 }}>
                                        <XAxis type="number" hide />
                                        <YAxis
                                            type="category"
                                            dataKey="nombre"
                                            width={80}
                                            tick={{ fontSize: 13 }}
                                        />
                                        <Tooltip />
                                        <Bar dataKey="sistemas" fill="hsl(221.2, 83.2%, 53.3%)" radius={[0, 6, 6, 0]} />
                                    </BarChart>
                                </ResponsiveContainer>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Recent interventions */}
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <div>
                            <CardTitle className="text-base">Intervenciones recientes</CardTitle>
                            <CardDescription>Últimas 5 intervenciones registradas</CardDescription>
                        </div>
                    </CardHeader>
                    <CardContent>
                        {recientes.length === 0 ? (
                            <div className="flex flex-col items-center justify-center py-8 text-center">
                                <AlertCircle className="h-10 w-10 text-muted-foreground/50 mb-3" />
                                <p className="text-sm text-muted-foreground">
                                    No hay intervenciones registradas todavía
                                </p>
                            </div>
                        ) : (
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm">
                                    <thead>
                                        <tr className="border-b text-left">
                                            <th className="pb-3 font-medium text-muted-foreground">Referencia</th>
                                            <th className="pb-3 font-medium text-muted-foreground">Título</th>
                                            <th className="pb-3 font-medium text-muted-foreground">Cliente</th>
                                            <th className="pb-3 font-medium text-muted-foreground">Tipo</th>
                                            <th className="pb-3 font-medium text-muted-foreground">Estado</th>
                                            <th className="pb-3 font-medium text-muted-foreground">Fecha</th>
                                            <th className="pb-3 font-medium text-muted-foreground text-right">Sistemas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {recientes.map((item) => (
                                            <tr key={item.id} className="border-b last:border-0 hover:bg-muted/50">
                                                <td className="py-3 font-mono text-xs font-medium">
                                                    {item.referencia}
                                                </td>
                                                <td className="py-3 max-w-[200px] truncate">
                                                    {item.titulo}
                                                </td>
                                                <td className="py-3 text-muted-foreground">
                                                    {item.cliente}
                                                </td>
                                                <td className="py-3">
                                                    <Badge variant="outline" className="text-xs">
                                                        {tipoLabels[item.tipo]}
                                                    </Badge>
                                                </td>
                                                <td className="py-3">
                                                    <span className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${estadoColors[item.estado]}`}>
                                                        {estadoLabels[item.estado]}
                                                    </span>
                                                </td>
                                                <td className="py-3 text-muted-foreground">
                                                    {item.fecha_inicio || '—'}
                                                </td>
                                                <td className="py-3 text-right font-medium">
                                                    {item.sistemas_count}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
