import { Head, Link } from '@inertiajs/react';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { toast } from 'sonner';
import { display } from '@/routes/queue';
import { copyToClipboard } from '@/lib/utils';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
    DialogClose,
} from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import admin from '@/routes/admin';

interface Event {
    id: number;
    name: string;
    event_date: string;
    venue: string;
    status: string;
    registrations_count: number;
}

interface Props {
    events: Event[];
}

function DeleteEventDialog({
    event,
    open,
    onOpenChange,
}: {
    event: Event;
    open: boolean;
    onOpenChange: (open: boolean) => void;
}) {
    const [processing, setProcessing] = useState(false);

    function handleDelete() {
        setProcessing(true);
        router.delete(admin.events.destroy(event.id).url, {
            onFinish: () => setProcessing(false),
        });
        onOpenChange(false);
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete Event</DialogTitle>
                    <DialogDescription>
                        Are you sure you want to delete "{event.name}"? This action cannot be undone.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <DialogClose asChild>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="button" variant="destructive" disabled={processing} onClick={handleDelete}>
                        {processing ? 'Deleting...' : 'Delete'}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}

export default function EventsIndex({ events }: Props) {
    const [deletingEvent, setDeletingEvent] = useState<Event | null>(null);

    return (
        <>
            <Head title="Events" />
            <div className="p-6">
                <div className="mb-6 flex items-center justify-between">
                    <h1 className="text-2xl font-bold">Events</h1>
                    <Link href={admin.events.create().url}>
                        <Button>Add Event</Button>
                    </Link>
                </div>

                <div className="rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Date</TableHead>
                                <TableHead>Venue</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Registrations</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {events.map((event) => (
                                <TableRow key={event.id}>
                                    <TableCell className="font-medium">{event.name}</TableCell>
                                    <TableCell className="text-muted-foreground">{event.event_date}</TableCell>
                                    <TableCell className="text-muted-foreground">{event.venue}</TableCell>
                                    <TableCell>
                                        <Badge
                                            variant={
                                                event.status === 'completed'
                                                    ? 'default'
                                                    : event.status === 'ongoing'
                                                      ? 'default'
                                                      : 'secondary'
                                            }
                                        >
                                            {event.status}
                                        </Badge>
                                    </TableCell>
                                    <TableCell className="text-muted-foreground">{event.registrations_count}</TableCell>
                                    <TableCell className="text-right">
                                        <Link href={admin.events.donors(event.id).url} className="mr-3 text-sm text-muted-foreground hover:text-foreground">
                                            Donors
                                        </Link>
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            className="mr-3 text-sm text-muted-foreground hover:text-foreground"
                                            onClick={() => {
                                                copyToClipboard(window.location.origin + display.url(event.id));
                                                toast.success('Display link copied!');
                                            }}
                                        >
                                            Share Display
                                        </Button>
                                        <Link href={admin.events.edit(event.id).url} className="mr-3 text-sm text-muted-foreground hover:text-foreground">
                                            Edit
                                        </Link>
                                        <Button onClick={() => setDeletingEvent(event)} variant="ghost" size="sm" className="text-destructive">
                                            Delete
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            </div>

            {deletingEvent && (
                <DeleteEventDialog
                    event={deletingEvent}
                    open={!!deletingEvent}
                    onOpenChange={(open) => {
 if (!open) {
setDeletingEvent(null);
} 
}}
                />
            )}
        </>
    );
}
