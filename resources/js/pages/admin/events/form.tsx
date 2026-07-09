import { Head, Link, Form } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import admin from '@/routes/admin';

interface Event {
    id: number;
    name: string;
    description: string | null;
    event_date: string;
    venue: string;
    status: string;
}

interface Props {
    event?: Event | null;
}

export default function EventForm({ event }: Props) {
    const isEditing = Boolean(event);

    return (
        <>
            <Head title={isEditing ? 'Edit Event' : 'Create Event'} />
            <div className="p-6">
                <h1 className="mb-6 text-2xl font-bold">
                    {isEditing ? 'Edit Event' : 'Create Event'}
                </h1>

                <div className="mx-auto max-w-lg">
                    <Card>
                        <CardContent className="p-6">
                            <Form
                                {...(isEditing
                                    ? admin.events.update.form(event!.id)
                                    : admin.events.store.form())}
                            >
                                {({ errors, processing }) => (
                                    <div className="space-y-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="name">Event Name</Label>
                                            <Input id="name" type="text" name="name" defaultValue={event?.name ?? ''} />
                                            {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="description">Description</Label>
                                            <Textarea id="description" name="description" rows={3} defaultValue={event?.description ?? ''} />
                                            {errors.description && <p className="text-sm text-destructive">{errors.description}</p>}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="event_date">Event Date</Label>
                                            <Input id="event_date" type="date" name="event_date" defaultValue={event?.event_date ?? ''} />
                                            {errors.event_date && <p className="text-sm text-destructive">{errors.event_date}</p>}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="venue">Venue</Label>
                                            <Input id="venue" type="text" name="venue" defaultValue={event?.venue ?? ''} />
                                            {errors.venue && <p className="text-sm text-destructive">{errors.venue}</p>}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="status">Status</Label>
                                            <select
                                                id="status"
                                                name="status"
                                                defaultValue={event?.status ?? 'upcoming'}
                                                className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-colors focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 outline-none md:text-sm"
                                            >
                                                <option value="upcoming">Upcoming</option>
                                                <option value="ongoing">Ongoing</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                            {errors.status && <p className="text-sm text-destructive">{errors.status}</p>}
                                        </div>

                                        <div className="flex items-center gap-4 pt-4">
                                            <Link href={admin.events.index().url}>
                                                <Button variant="outline" type="button">Cancel</Button>
                                            </Link>
                                            <Button type="submit" disabled={processing}>
                                                {processing ? 'Saving...' : isEditing ? 'Update Event' : 'Create Event'}
                                            </Button>
                                        </div>
                                    </div>
                                )}
                            </Form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </>
    );
}
