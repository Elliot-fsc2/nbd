import { Head } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';

export default function Dashboard() {
    return (
        <>
            <Head title="Admin Dashboard" />
            <div className="p-6">
                <h1 className="mb-6 text-2xl font-bold">Admin Dashboard</h1>
                <Card>
                    <CardContent className="p-6">
                        <p className="text-muted-foreground">Welcome to the admin dashboard.</p>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
