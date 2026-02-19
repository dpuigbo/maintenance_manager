export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};

export interface DashboardStats {
    clientes: number;
    sistemas: number;
    intervenciones: number;
    informes: number;
    intervenciones_en_curso: number;
    informes_pendientes: number;
}

export interface IntervencionReciente {
    id: number;
    referencia: string;
    titulo: string;
    cliente: string;
    tipo: 'preventiva' | 'correctiva';
    estado: 'borrador' | 'en_curso' | 'completada' | 'facturada';
    fecha_inicio: string | null;
    sistemas_count: number;
}

export interface EstadoChart {
    name: string;
    value: number;
    color: string;
}

export interface FabricanteChart {
    nombre: string;
    sistemas: number;
}
