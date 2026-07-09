import { Head, Link } from '@inertiajs/react';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent } from '@/components/ui/card';
import staff from '@/routes/staff';

interface Event {
    id: number;
    name: string;
    event_date: string;
    venue: string;
    status: string;
}

interface QueueIndexProps {
    events: Event[];
}

export default function QueueIndex({ events }: QueueIndexProps) {
    return (
        <>
            <Head title="Queue Management" />
            <div className="p-6">
                <h1 className="mb-2 text-2xl font-bold">Queue Management</h1>
                <h2 className="mb-6 text-muted-foreground">Select an Event</h2>

                {events.length === 0 ? (
                    <p className="text-muted-foreground">No upcoming or ongoing events.</p>
                ) : (
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {events.map((event) => (
                            <Link key={event.id} href={staff.events.queue(event.id)?.url || `/staff/events/${event.id}/queue`}>
                                <Card className="transition hover:shadow-md cursor-pointer">
                                    <CardContent className="p-6">
                                        <h3 className="text-lg font-semibold">{event.name}</h3>
                                        <p className="mt-1 text-sm text-muted-foreground">
                                            {new Date(event.event_date).toLocaleDateString()}
                                        </p>
                                        {event.venue && (
                                            <p className="text-sm text-muted-foreground">{event.venue}</p>
                                        )}
                                        <Badge
                                            variant={event.status === 'ongoing' ? 'default' : 'secondary'}
                                            className="mt-2"
                                        >
                                            {event.status}
                                        </Badge>
                                    </CardContent>
                                </Card>
                            </Link>
                        ))}
                    </div>
                )}
            </div>
        </>
    );
}
