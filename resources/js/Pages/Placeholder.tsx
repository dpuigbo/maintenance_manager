import AppLayout from '@/Layouts/AppLayout';
import { Head } from '@inertiajs/react';
import { Card, CardContent } from '@/Components/ui/card';
import { Construction } from 'lucide-react';

interface Props {
    section: string;
}

export default function Placeholder({ section }: Props) {
    return (
        <AppLayout>
            <Head title={section} />

            <div className="space-y-6">
                <div>
                    <h1 className="text-2xl font-bold tracking-tight">{section}</h1>
                    <p className="text-muted-foreground">
                        Gestión de {section.toLowerCase()}
                    </p>
                </div>

                <Card>
                    <CardContent className="flex flex-col items-center justify-center py-16">
                        <Construction className="h-12 w-12 text-muted-foreground/40 mb-4" />
                        <h3 className="text-lg font-semibold mb-1">En construcción</h3>
                        <p className="text-sm text-muted-foreground text-center max-w-md">
                            La sección de {section.toLowerCase()} está en desarrollo.
                            Pronto podrás gestionar tus {section.toLowerCase()} desde aquí.
                        </p>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
