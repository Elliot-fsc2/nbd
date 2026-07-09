import { Head, Link, useForm } from '@inertiajs/react';
import { usePoll } from '@inertiajs/react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Separator } from '@/components/ui/separator';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { toast } from 'sonner';
import { display } from '@/routes/queue';
import { copyToClipboard } from '@/lib/utils';
import staff from '@/routes/staff';

interface Donor {
    id: number;
    full_name: string;
    id_number: string | null;
    email: string;
    tracking_code: string;
}

interface EventRegistration {
    id: number;
    donor: Donor;
    queue_number: string;
    status: string;
}

interface Event {
    id: number;
    name: string;
    event_date: string;
    venue: string;
    status: string;
}

interface EventQueueProps {
    event: Event;
    current: EventRegistration | null;
    waiting: EventRegistration[];
    completed: EventRegistration[];
}

export default function EventQueue({ event, current, waiting, completed }: EventQueueProps) {
    usePoll(5000, { only: ['current', 'waiting', 'completed'] });

    const { data, setData, post, processing, errors, reset } = useForm({
        id_number: '',
    });

    function handleCheckIn(e: React.FormEvent) {
        e.preventDefault();
        post(staff.events.checkin(event.id)?.url || `/staff/events/${event.id}/checkin`, {
            onSuccess: () => reset(),
        });
    }

    return (
        <>
            <Head title={`Queue - ${event.name}`} />
            <div className="p-6">
                <div className="mb-6">
                    <Link href={staff.queue().url} className="mb-2 inline-block text-sm text-muted-foreground hover:text-foreground">
                        &larr; All Events
                    </Link>
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-2xl font-bold">{event.name}</h1>
                            <p className="text-sm text-muted-foreground">
                                {event.venue && <span>{event.venue} &middot; </span>}
                                {new Date(event.event_date).toLocaleDateString()} &middot;
                                <Badge variant="default" className="ml-1">Ongoing</Badge>
                            </p>
                        </div>
                        <div className="flex items-center gap-3">
                            <Button
                                variant="outline"
                                size="sm"
                                onClick={() => {
                                    copyToClipboard(window.location.origin + display.url(event.id));
                                    toast.success('Display link copied!');
                                }}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="mr-1"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
                                Share Link
                            </Button>
                            <a
                                href={`/queue/${event.id}/display`}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="inline-flex items-center gap-2 rounded-lg border border-primary/30 bg-primary/10 px-4 py-2 text-sm font-medium text-primary hover:bg-primary/20 transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                TV Display
                            </a>
                        </div>
                    </div>
                </div>

                <div className="grid gap-6 lg:grid-cols-3">
                    <div className="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Current</CardTitle>
                            </CardHeader>
                            <CardContent>
                                {current ? (
                                    <div className="rounded-lg border-2 border-primary bg-primary/5 p-4">
                                        <p className="text-3xl font-bold text-primary">
                                            #{current.queue_number}
                                        </p>
                                        <p className="mt-2 text-xl font-semibold">
                                            {current.donor.full_name}
                                        </p>
                                        <p className="text-sm text-muted-foreground">
                                            ID: {current.donor.id_number ?? 'N/A'}
                                        </p>
                                        <div className="mt-4 flex gap-3">
                                            <form action={staff.queue.complete(current.id)?.url || `/staff/queue/${current.id}/complete`} method="post">
                                                <Button type="submit" variant="default">Complete</Button>
                                            </form>
                                            <form action={staff.queue.skip(current.id)?.url || `/staff/queue/${current.id}/skip`} method="post">
                                                <Button type="submit" variant="secondary">Skip</Button>
                                            </form>
                                        </div>
                                    </div>
                                ) : (
                                    <p className="text-muted-foreground">No donor currently in progress.</p>
                                )}
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Waiting ({waiting.length})</CardTitle>
                            </CardHeader>
                            <CardContent>
                                {waiting.length === 0 ? (
                                    <p className="text-muted-foreground">No donors waiting.</p>
                                ) : (
                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>#</TableHead>
                                                <TableHead>Name / ID</TableHead>
                                                <TableHead>Status</TableHead>
                                                <TableHead className="text-right">Action</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {waiting.map((reg) => (
                                                <TableRow key={reg.id}>
                                                    <TableCell className="font-bold">{reg.queue_number?.slice(-3)}</TableCell>
                                                    <TableCell>
                                                        <p className="font-medium">{reg.donor.full_name}</p>
                                                        <p className="text-xs text-muted-foreground">{reg.donor.id_number ?? 'N/A'}</p>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Badge variant="secondary">Waiting</Badge>
                                                    </TableCell>
                                                    <TableCell className="text-right">
                                                        <form action={staff.queue.next(reg.id)?.url || `/staff/queue/${reg.id}/next`} method="post">
                                                            <Button type="submit" size="sm">Call</Button>
                                                        </form>
                                                    </TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                )}
                            </CardContent>
                        </Card>
                    </div>

                    <div className="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Check In New Donor</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={handleCheckIn} className="space-y-3">
                                    <div className="space-y-2">
                                        <Input
                                            type="text"
                                            value={data.id_number}
                                            onChange={(e) => setData('id_number', e.target.value)}
                                            placeholder="Enter ID number..."
                                        />
                                        {errors.id_number && (
                                            <p className="text-sm text-destructive">{errors.id_number}</p>
                                        )}
                                    </div>
                                    <Button type="submit" disabled={processing} className="w-full">
                                        {processing ? 'Checking...' : 'Assign Number'}
                                    </Button>
                                </form>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Recent Activity</CardTitle>
                            </CardHeader>
                            <CardContent>
                                {completed.length === 0 ? (
                                    <p className="text-muted-foreground">No recent activity.</p>
                                ) : (
                                    <ul className="space-y-2">
                                        {completed.map((reg) => (
                                            <li key={reg.id}>
                                                <Separator className="mb-2" />
                                                <p className="text-sm font-medium">{reg.donor.full_name}</p>
                                                <p className="text-xs text-muted-foreground">
                                                    #{reg.queue_number} &middot; {reg.status}
                                                </p>
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </>
    );
}
