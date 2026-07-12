import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader } from '@/components/ui/card';
import { home } from '@/routes';

const messages: Record<number, { title: string; description: string }> = {
    403: { title: '403', description: 'You do not have permission to access this page.' },
    404: { title: '404', description: 'Page not found.' },
    500: { title: '500', description: 'Something went wrong on our end.' },
    503: { title: '503', description: 'Service unavailable. Please try again later.' },
};

export default function ErrorPage({ status }: { status?: number }) {
    const error = messages[status ?? 404] ?? messages[404];

    return (
        <div className="flex min-h-screen items-center justify-center bg-muted/30 p-4">
            <Card className="w-full max-w-md text-center">
                <CardHeader>
                    <p className="text-7xl font-black text-red-500">{error.title}</p>
                </CardHeader>
                <CardContent className="space-y-4">
                    <p className="text-lg text-muted-foreground">
                        {error.description}
                    </p>
                    <Button asChild>
                        <Link href={home().url}>Go Home</Link>
                    </Button>
                </CardContent>
            </Card>
        </div>
    );
}
