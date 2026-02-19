import { Link, usePage } from '@inertiajs/react';
import { PropsWithChildren, useState } from 'react';
import {
    LayoutDashboard,
    Users,
    Factory,
    Bot,
    Wrench,
    ClipboardList,
    Settings,
    ChevronLeft,
    LogOut,
    User as UserIcon,
    Menu,
    X,
    Cpu,
    Droplets,
    Package,
} from 'lucide-react';
import { cn } from '@/lib/utils';
import { Button } from '@/Components/ui/button';
import { ScrollArea } from '@/Components/ui/scroll-area';
import { Separator } from '@/Components/ui/separator';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import { Avatar, AvatarFallback } from '@/Components/ui/avatar';

interface NavItem {
    label: string;
    href: string;
    icon: React.ElementType;
    routeName: string;
}

const navSections: { title: string; items: NavItem[] }[] = [
    {
        title: 'General',
        items: [
            { label: 'Dashboard', href: '/dashboard', icon: LayoutDashboard, routeName: 'dashboard' },
        ],
    },
    {
        title: 'Gestión',
        items: [
            { label: 'Clientes', href: '/clientes', icon: Users, routeName: 'clientes.*' },
            { label: 'Intervenciones', href: '/intervenciones', icon: ClipboardList, routeName: 'intervenciones.*' },
        ],
    },
    {
        title: 'Configuración',
        items: [
            { label: 'Fabricantes', href: '/fabricantes', icon: Factory, routeName: 'fabricantes.*' },
            { label: 'Modelos', href: '/modelos', icon: Cpu, routeName: 'modelos.*' },
            { label: 'Aceites', href: '/aceites', icon: Droplets, routeName: 'aceites.*' },
            { label: 'Consumibles', href: '/consumibles', icon: Package, routeName: 'consumibles.*' },
        ],
    },
];

export default function AppLayout({ children }: PropsWithChildren) {
    const { auth } = usePage<{ auth: { user: { id: number; name: string; email: string } } }>().props;
    const [collapsed, setCollapsed] = useState(false);
    const [mobileOpen, setMobileOpen] = useState(false);

    const initials = auth.user.name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);

    const isActive = (routeName: string) => {
        try {
            return route().current(routeName);
        } catch {
            return false;
        }
    };

    const sidebarContent = (
        <div className="flex h-full flex-col">
            {/* Logo */}
            <div className={cn("flex items-center gap-3 px-4 py-5", collapsed && "justify-center px-2")}>
                <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary text-primary-foreground font-bold text-sm">
                    <Bot className="h-5 w-5" />
                </div>
                {!collapsed && (
                    <div className="flex flex-col">
                        <span className="text-sm font-bold text-foreground">PAS Robotics</span>
                        <span className="text-xs text-muted-foreground">Manage</span>
                    </div>
                )}
            </div>

            <Separator />

            {/* Navigation */}
            <ScrollArea className="flex-1 px-3 py-4">
                <nav className="space-y-6">
                    {navSections.map((section) => (
                        <div key={section.title}>
                            {!collapsed && (
                                <p className="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                                    {section.title}
                                </p>
                            )}
                            <div className="space-y-1">
                                {section.items.map((item) => {
                                    const active = isActive(item.routeName);
                                    return (
                                        <Link
                                            key={item.href}
                                            href={item.href}
                                            className={cn(
                                                "flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors",
                                                active
                                                    ? "bg-primary text-primary-foreground"
                                                    : "text-muted-foreground hover:bg-accent hover:text-accent-foreground",
                                                collapsed && "justify-center px-2"
                                            )}
                                            title={collapsed ? item.label : undefined}
                                        >
                                            <item.icon className="h-4 w-4 shrink-0" />
                                            {!collapsed && <span>{item.label}</span>}
                                        </Link>
                                    );
                                })}
                            </div>
                        </div>
                    ))}
                </nav>
            </ScrollArea>

            <Separator />

            {/* User section */}
            <div className={cn("p-3", collapsed && "px-2")}>
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <button
                            className={cn(
                                "flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm transition-colors hover:bg-accent",
                                collapsed && "justify-center px-2"
                            )}
                        >
                            <Avatar className="h-8 w-8">
                                <AvatarFallback className="bg-primary/10 text-primary text-xs font-semibold">
                                    {initials}
                                </AvatarFallback>
                            </Avatar>
                            {!collapsed && (
                                <div className="flex flex-col items-start text-left min-w-0">
                                    <span className="text-sm font-medium truncate w-full">{auth.user.name}</span>
                                    <span className="text-xs text-muted-foreground truncate w-full">{auth.user.email}</span>
                                </div>
                            )}
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent side="top" align="start" className="w-56">
                        <DropdownMenuLabel>Mi cuenta</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem asChild>
                            <Link href={route('profile.edit')} className="cursor-pointer">
                                <UserIcon className="mr-2 h-4 w-4" />
                                Perfil
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem asChild>
                            <Link href={route('logout')} method="post" as="button" className="w-full cursor-pointer">
                                <LogOut className="mr-2 h-4 w-4" />
                                Cerrar sesión
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
    );

    return (
        <div className="flex h-screen overflow-hidden bg-background">
            {/* Mobile overlay */}
            {mobileOpen && (
                <div
                    className="fixed inset-0 z-40 bg-black/50 lg:hidden"
                    onClick={() => setMobileOpen(false)}
                />
            )}

            {/* Mobile sidebar */}
            <aside
                className={cn(
                    "fixed inset-y-0 left-0 z-50 w-64 bg-card border-r transform transition-transform duration-200 lg:hidden",
                    mobileOpen ? "translate-x-0" : "-translate-x-full"
                )}
            >
                <div className="absolute right-2 top-2">
                    <Button variant="ghost" size="icon" onClick={() => setMobileOpen(false)}>
                        <X className="h-5 w-5" />
                    </Button>
                </div>
                {sidebarContent}
            </aside>

            {/* Desktop sidebar */}
            <aside
                className={cn(
                    "hidden lg:flex flex-col border-r bg-card transition-all duration-200",
                    collapsed ? "w-[68px]" : "w-64"
                )}
            >
                {sidebarContent}
                <div className="border-t p-2">
                    <Button
                        variant="ghost"
                        size="icon"
                        className="w-full"
                        onClick={() => setCollapsed(!collapsed)}
                    >
                        <ChevronLeft className={cn("h-4 w-4 transition-transform", collapsed && "rotate-180")} />
                    </Button>
                </div>
            </aside>

            {/* Main content */}
            <main className="flex-1 overflow-auto">
                {/* Mobile top bar */}
                <div className="sticky top-0 z-30 flex items-center gap-4 border-b bg-card px-4 py-3 lg:hidden">
                    <Button variant="ghost" size="icon" onClick={() => setMobileOpen(true)}>
                        <Menu className="h-5 w-5" />
                    </Button>
                    <div className="flex items-center gap-2">
                        <Bot className="h-5 w-5 text-primary" />
                        <span className="font-bold text-sm">PAS Robotics Manage</span>
                    </div>
                </div>

                <div className="p-6 lg:p-8">
                    {children}
                </div>
            </main>
        </div>
    );
}
