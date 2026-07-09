import { Link, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { Toaster } from '@/components/ui/sonner';
import { logout } from '@/routes';
import admin from '@/routes/admin';
import staff from '@/routes/staff';

interface User {
    id: number;
    name: string;
    email: string;
    role: string;
}

interface Auth {
    user: User | null;
}

interface Flash {
    success?: string;
    error?: string;
}

interface PageProps {
    auth: Auth;
    flash?: Flash;
    [key: string]: unknown;
}

interface NavItem {
    label: string;
    href: string;
}

const adminNav: NavItem[] = [
    { label: 'Dashboard', href: admin.dashboard().url },
    { label: 'Hospitals', href: admin.hospitals.index().url },
    { label: 'Departments', href: admin.departments.index().url },
    { label: 'Events', href: admin.events.index().url },
    { label: 'Donors', href: admin.donors.index().url },
    { label: 'Courses', href: admin.courses.index().url },
    { label: 'Users', href: admin.users.index().url },
];

export default function AuthenticatedLayout({ children }: { children: React.ReactNode }) {
    const { auth, flash } = usePage<PageProps>().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const user = auth.user;
    const isAdmin = user?.role === 'admin';

    const navItems = isAdmin ? adminNav : [];

    useEffect(() => {
        if (flash?.success) {
toast.success(flash.success);
}

        if (flash?.error) {
toast.error(flash.error);
}
    }, [flash?.success, flash?.error]);

    return (
        <div className="min-h-screen bg-muted/30">
            <aside className="fixed left-0 top-0 z-30 hidden h-screen w-64 flex-col border-r bg-card lg:flex">
                <div className="flex items-center justify-between border-b px-6 py-4">
                    <Link href={isAdmin ? admin.dashboard().url : staff.queue().url} className="text-lg font-bold">
                        Blood Donation
                    </Link>
                </div>

                <nav className="flex-1 overflow-y-auto py-4">
                    {isAdmin ? (
                        <ul className="space-y-1 px-3">
                            {adminNav.map((item) => (
                                <li key={item.label}>
                                    <Link
                                        href={item.href}
                                        className="flex rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground"
                                    >
                                        {item.label}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    ) : (
                        <ul className="space-y-1 px-3">
                            <li>
                                <Link href={staff.queue().url} className="flex rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                                    Events
                                </Link>
                            </li>
                        </ul>
                    )}
                </nav>

                <div className="border-t px-6 py-4">
                    <div className="mb-3 text-sm">
                        <p className="font-medium text-foreground">{user?.name}</p>
                        <p className="text-xs text-muted-foreground">{user?.email}</p>
                    </div>
                    <Link
                        href={logout().url}
                        method="post"
                        as="button"
                        className="w-full"
                    >
                        <Button variant="destructive" className="w-full">
                            Logout
                        </Button>
                    </Link>
                </div>
            </aside>

            <Sheet open={sidebarOpen} onOpenChange={setSidebarOpen}>
                <SheetTrigger asChild className="lg:hidden">
                    <Button variant="ghost" size="icon" className="fixed top-4 left-4 z-50">
                        <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </Button>
                </SheetTrigger>
                <SheetContent side="left" className="w-64 p-0">
                    <div className="flex h-full flex-col">
                        <div className="flex items-center border-b px-6 py-4">
                            <Link href={isAdmin ? admin.dashboard().url : staff.queue().url} className="text-lg font-bold">
                                Blood Donation
                            </Link>
                        </div>

                        <nav className="flex-1 overflow-y-auto py-4">
                            {isAdmin ? (
                                <ul className="space-y-1 px-3">
                                    {adminNav.map((item) => (
                                        <li key={item.label}>
                                            <Link
                                                href={item.href}
                                                className="flex rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground"
                                                onClick={() => setSidebarOpen(false)}
                                            >
                                                {item.label}
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            ) : (
                                <ul className="space-y-1 px-3">
                                    <li>
                                        <Link
                                            href={staff.queue().url}
                                            className="flex rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground"
                                            onClick={() => setSidebarOpen(false)}
                                        >
                                            Events
                                        </Link>
                                    </li>
                                </ul>
                            )}
                        </nav>

                        <div className="border-t px-6 py-4">
                            <div className="mb-3 text-sm">
                                <p className="font-medium text-foreground">{user?.name}</p>
                                <p className="text-xs text-muted-foreground">{user?.email}</p>
                            </div>
                            <Link
                                href={logout().url}
                                method="post"
                                as="button"
                                className="w-full"
                            >
                                <Button variant="destructive" className="w-full">
                                    Logout
                                </Button>
                            </Link>
                        </div>
                    </div>
                </SheetContent>
            </Sheet>

            <div className="flex min-h-screen flex-col lg:ml-64">
                <header className="flex items-center justify-between border-b bg-card px-4 py-3 lg:hidden">
                    <div />
                    <span className="text-sm font-medium">{user?.name}</span>
                </header>

                <main className="flex-1">
                    {children}
                </main>
            </div>

            <Toaster />
        </div>
    );
}
