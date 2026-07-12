import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
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

interface Props {
    event: Event;
    registrations: {
        data: Registration[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number;
        to: number;
    };
    filters: {
        search?: string;
    };
}

export default function EventDonors({ event, registrations, filters }: Props) {
    const [search, setSearch] = useState(filters.search ?? '');

    function handleSearch(e: React.FormEvent) {
        e.preventDefault();
        router.visit(admin.events.donors(event.id).url, {
            data: { search },
            preserveState: true,
            preserveScroll: true,
        });
    }
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

                <form onSubmit={handleSearch} className="mb-4">
                    <div className="flex max-w-sm gap-2">
                        <Input
                            type="text"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            placeholder="Search donors..."
                        />
                        <Button type="submit">Search</Button>
                    </div>
                </form>

                <p className="mb-2 text-sm text-muted-foreground">
                    {registrations.total > 0
                        ? `Showing ${registrations.from} to ${registrations.to} of ${registrations.total} donors`
                        : 'No donors found'}
                </p>

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
                                        <TableCell className="text-muted-foreground">{registrations.from + index}</TableCell>
                                        <TableCell className="font-medium">{registration.given_name} {registration.surname}</TableCell>
                                        <TableCell className="text-muted-foreground">{registration.blood_type}</TableCell>
                                        <TableCell className="text-muted-foreground">{registration.created_at}</TableCell>
                                    </TableRow>
                                ))
                            )}
                        </TableBody>
                    </Table>
                </div>

                {registrations.last_page > 1 && (
                    <div className="mt-4 flex items-center justify-between">
                        <p className="text-sm text-muted-foreground">
                            Page {registrations.current_page} of {registrations.last_page}
                        </p>
                        <div className="flex gap-2">
                            {registrations.current_page > 1 && (
                                <Link href={admin.events.donors(event.id).url} data={{ page: registrations.current_page - 1 }} preserveState preserveScroll>
                                    <Button variant="outline" size="sm">Previous</Button>
                                </Link>
                            )}
                            {registrations.current_page < registrations.last_page && (
                                <Link href={admin.events.donors(event.id).url} data={{ page: registrations.current_page + 1 }} preserveState preserveScroll>
                                    <Button variant="outline" size="sm">Next</Button>
                                </Link>
                            )}
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}
