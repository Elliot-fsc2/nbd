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
            <div className="mx-auto w-full max-w-[2000px] p-4 md:p-6">
                <h1 className="mb-1 text-xl font-bold md:text-2xl">Queue Management</h1>
                <h2 className="mb-4 text-sm text-muted-foreground md:mb-6 md:text-base">Select an Event</h2>

                {events.length === 0 ? (
                    <p className="text-muted-foreground">No upcoming or ongoing events.</p>
                ) : (
                    <div className="grid gap-3 sm:gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
                        {events.map((event) => (
                            <Link key={event.id} href={staff.events.queue(event.id)?.url || `/staff/events/${event.id}/queue`}>
                                <Card className="transition hover:shadow-md cursor-pointer h-full">
                                    <CardContent className="p-4 md:p-6">
                                        <h3 className="text-base font-semibold md:text-lg">{event.name}</h3>
                                        <p className="mt-1 text-xs text-muted-foreground md:text-sm">
                                            {new Date(event.event_date).toLocaleDateString()}
                                        </p>
                                        {event.venue && (
                                            <p className="text-xs text-muted-foreground md:text-sm">{event.venue}</p>
                                        )}
                                        <Badge
                                            variant={event.status === 'ongoing' ? 'default' : 'secondary'}
                                            className="mt-2 text-xs"
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
