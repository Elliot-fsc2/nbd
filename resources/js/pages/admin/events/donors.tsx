import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import admin from '@/routes/admin';

interface Event {
    id: number;
    name: string;
    event_date: string;
    venue: string;
}

interface Registration {
    id: number;
    given_name: string;
    surname: string;
    blood_type: string;
    created_at: string;
}

interface PaginatedData<T> {
    data: T[];
    meta: Record<string, unknown>;
}

interface Props {
    event: Event;
    registrations: PaginatedData<Registration>;
}

export default function EventDonors({ event, registrations }: Props) {
    return (
        <>
            <Head title={`Donors - ${event.name}`} />
            <div className="p-6">
                <div className="mb-6">
                    <h1 className="text-2xl font-bold">{event.name}</h1>
                    <p className="mt-1 text-sm text-muted-foreground">
                        {event.venue} &middot; {event.event_date}
                    </p>
                </div>

                <Link href={admin.events.index().url} className="mb-4 inline-block">
                    <Button variant="ghost" className="mb-4">&larr; Back to Events</Button>
                </Link>

                <div className="rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>#</TableHead>
                                <TableHead>Full Name</TableHead>
                                <TableHead>Blood Type</TableHead>
                                <TableHead>Registered At</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {registrations.data.length === 0 ? (
                                <TableRow>
                                    <TableCell colSpan={4} className="text-center text-muted-foreground">
                                        No donors registered for this event.
                                    </TableCell>
                                </TableRow>
                            ) : (
                                registrations.data.map((registration, index) => (
                                    <TableRow key={registration.id}>
                                        <TableCell className="text-muted-foreground">{index + 1}</TableCell>
                                        <TableCell className="font-medium">{registration.given_name} {registration.surname}</TableCell>
                                        <TableCell className="text-muted-foreground">{registration.blood_type}</TableCell>
                                        <TableCell className="text-muted-foreground">{registration.created_at}</TableCell>
                                    </TableRow>
                                ))
                            )}
                        </TableBody>
                    </Table>
                </div>
            </div>
        </>
    );
}
