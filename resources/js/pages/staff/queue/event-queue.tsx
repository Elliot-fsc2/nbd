import { Head, Link, router, usePage } from '@inertiajs/react';
import { usePoll } from '@inertiajs/react';
import { useEffect, useRef, useState } from 'react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from '@/components/ui/dialog';
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

interface Hospital {
    id: number;
    name: string;
    code: string;
}

interface EventRegistration {
    id: number;
    donor: Donor;
    hospital: Hospital | null;
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

interface FlashData {
    success?: string;
    error?: string;
    last_checked_in?: {
        queue_number: string;
        donor_name: string;
        event_name: string;
    };
}

interface EventQueueProps {
    event: Event;
    current: EventRegistration[];
    waiting: EventRegistration[];
    completed: EventRegistration[];
}

export default function EventQueue({ event, current, waiting, completed }: EventQueueProps) {
    usePoll(5000, { only: ['current', 'waiting', 'completed'] });

    const { errors, flash } = usePage().props as {
        errors: Record<string, string>;
        flash: FlashData;
    };

    const [showReceipt, setShowReceipt] = useState(false);
    const [receiptData, setReceiptData] = useState<FlashData['last_checked_in'] | null>(null);
    const [checkingIn, setCheckingIn] = useState(false);
    const [activitySearch, setActivitySearch] = useState('');
    const [query, setQuery] = useState('');
    const [results, setResults] = useState<Donor[]>([]);
    const [selectedDonor, setSelectedDonor] = useState<Donor | null>(null);
    const [open, setOpen] = useState(false);
    const [loading, setLoading] = useState(false);
    const debounceRef = useRef<ReturnType<typeof setTimeout>>();
    const dropdownRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        if (debounceRef.current) clearTimeout(debounceRef.current);

        if (query.length < 2) {
            setResults([]);
            setOpen(false);
            return;
        }

        debounceRef.current = setTimeout(async () => {
            setLoading(true);
            try {
                const res = await fetch(`/staff/donors/search?q=${encodeURIComponent(query)}`);
                const data: Donor[] = await res.json();
                setResults(data);
                setOpen(data.length > 0);
            } finally {
                setLoading(false);
            }
        }, 300);

        return () => { if (debounceRef.current) clearTimeout(debounceRef.current); };
    }, [query]);

    const activityDebounceRef = useRef<ReturnType<typeof setTimeout>>();

    useEffect(() => {
        if (activityDebounceRef.current) clearTimeout(activityDebounceRef.current);

        activityDebounceRef.current = setTimeout(() => {
            router.get(staff.events.queue(event.id)?.url || `/staff/events/${event.id}/queue`, {
                search: activitySearch || undefined,
            }, {
                preserveScroll: true,
                preserveState: true,
                replace: true,
            });
        }, 300);

        return () => { if (activityDebounceRef.current) clearTimeout(activityDebounceRef.current); };
    }, [activitySearch]);

    useEffect(() => {
        function handleClickOutside(e: MouseEvent) {
            if (dropdownRef.current && !dropdownRef.current.contains(e.target as Node)) {
                setOpen(false);
            }
        }
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    function selectDonor(donor: Donor) {
        setSelectedDonor(donor);
        setQuery(donor.full_name);
        setOpen(false);
    }

    function handleCheckIn() {
        if (!selectedDonor) return;

        setReceiptData({
            donor_name: selectedDonor.full_name,
            event_name: event.name,
        });
        setShowReceipt(true);
    }

    function handlePrint() {
        if (!selectedDonor) return;

        setCheckingIn(true);

        router.post(staff.events.checkin(event.id)?.url || `/staff/events/${event.id}/checkin`, {
            donor_id: selectedDonor.id,
        }, {
            preserveScroll: true,
            onSuccess: (page) => {
                const checkedIn = (page.props as any)?.flash?.last_checked_in as FlashData['last_checked_in'] | undefined;
                if (!checkedIn) return;

                setSelectedDonor(null);
                setQuery('');
                setResults([]);
                setShowReceipt(false);
                setCheckingIn(false);

                const el = document.createElement('div');
                el.id = 'print-receipt-print';
                el.innerHTML = `
                    <div style="text-align:center;padding:40px 20px;font-family:system-ui,sans-serif;">
                        <p style="font-size:12px;color:#666;text-transform:uppercase;letter-spacing:0.1em;margin:0 0 16px">${checkedIn.event_name}</p>
                        <hr style="border:none;border-top:1px dashed #ccc;margin:0 0 16px" />
                        <p style="font-size:14px;color:#666;margin:0 0 8px">Queue Number</p>
                        <p style="font-size:60px;font-weight:bold;letter-spacing:0.1em;color:#000;margin:0 0 16px">${checkedIn.queue_number}</p>
                        <hr style="border:none;border-top:1px dashed #ccc;margin:0 0 16px" />
                        <p style="font-size:14px;color:#666;margin:0 0 8px">Donor</p>
                        <p style="font-size:24px;font-weight:600;color:#000;margin:0 0 16px">${checkedIn.donor_name}</p>
                        <p style="font-size:12px;color:#666;margin:0">${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}</p>
                    </div>
                `;
                document.body.appendChild(el);

                window.onafterprint = () => {
                    document.body.removeChild(el);
                    window.onafterprint = null;
                };

                window.print();
            },
            onError: () => {
                setCheckingIn(false);
            },
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
                                <CardTitle>Serving ({current.length})</CardTitle>
                            </CardHeader>
                            <CardContent>
                                {current.length === 0 ? (
                                    <p className="text-muted-foreground">No donors currently in progress.</p>
                                ) : (
                                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                        {current.map((reg, i) => (
                                            <div key={reg.id} className="rounded-lg border-2 border-primary bg-primary/5 p-4">
                                                <p className="text-xs font-semibold text-primary/60 uppercase tracking-wider mb-1">
                                                    Booth {i + 1}
                                                </p>
                                                <p className="text-3xl font-bold text-primary">
                                                    #{reg.queue_number}
                                                </p>
                                                <p className="mt-2 text-xl font-semibold">
                                                    {reg.donor.full_name}
                                                </p>
                                                {reg.hospital && (
                                                    <p className="text-sm font-medium text-primary/70">
                                                        {reg.hospital.name}
                                                    </p>
                                                )}
                                                <p className="text-sm text-muted-foreground">
                                                    ID: {reg.donor.id_number ?? 'N/A'}
                                                </p>
                                                <div className="mt-4 flex gap-3">
                                                    <Button onClick={() => router.post(staff.queue.complete(reg.id)?.url || `/staff/queue/${reg.id}/complete`, {}, { preserveScroll: true })} variant="default">Complete</Button>
                                                    <Button onClick={() => router.post(staff.queue.skip(reg.id)?.url || `/staff/queue/${reg.id}/skip`, {}, { preserveScroll: true })} variant="secondary">Skip</Button>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
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
                                                        {reg.hospital && (
                                                            <p className="text-xs text-muted-foreground">{reg.hospital.name}</p>
                                                        )}
                                                    </TableCell>
                                                    <TableCell>
                                                        <Badge variant="secondary">Waiting</Badge>
                                                    </TableCell>
                                                    <TableCell className="text-right">
                                                            <Button onClick={() => router.post(staff.queue.next(reg.id)?.url || `/staff/queue/${reg.id}/next`, {}, { preserveScroll: true })} size="sm">Call</Button>
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
                            <CardContent className="space-y-3">
                                <div className="relative" ref={dropdownRef}>
                                    <Input
                                        type="text"
                                        value={query}
                                        onChange={(e) => {
                                            setQuery(e.target.value);
                                            if (selectedDonor) setSelectedDonor(null);
                                        }}
                                        placeholder="Search by ID number, name, or representative..."
                                    />
                                    {loading && (
                                        <div className="absolute right-3 top-1/2 -translate-y-1/2">
                                            <div className="h-4 w-4 animate-spin rounded-full border-2 border-muted-foreground border-t-transparent" />
                                        </div>
                                    )}
                                    {open && results.length > 0 && (
                                        <div className="absolute z-50 mt-1 w-full rounded-md border bg-popover shadow-md">
                                            {results.map((donor) => (
                                                <button
                                                    key={donor.id}
                                                    type="button"
                                                    onClick={() => selectDonor(donor)}
                                                    className="flex w-full flex-col items-start px-3 py-2 text-left text-sm hover:bg-accent"
                                                >
                                                    <span className="font-medium">{donor.full_name}</span>
                                                    <span className="text-xs text-muted-foreground">
                                                        {donor.id_number ?? 'N/A'} &middot; {donor.email}
                                                    </span>
                                                </button>
                                            ))}
                                        </div>
                                    )}
                                    {errors.donor_id && (
                                        <p className="mt-1 text-sm text-destructive">{errors.donor_id}</p>
                                    )}
                                </div>

                                <Button
                                    onClick={handleCheckIn}
                                    disabled={!selectedDonor}
                                    className="w-full"
                                >
                                    Assign Number
                                </Button>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Recent Activity</CardTitle>
                                <Input
                                    type="text"
                                    value={activitySearch}
                                    onChange={(e) => setActivitySearch(e.target.value)}
                                    placeholder="Search activity..."
                                    className="mt-2"
                                />
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
                                                {reg.hospital && (
                                                    <p className="text-xs text-muted-foreground">{reg.hospital.name}</p>
                                                )}
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

            <Dialog open={showReceipt} onOpenChange={setShowReceipt}>
                <DialogContent className="sm:max-w-sm">
                    <DialogHeader>
                        <DialogTitle className="text-center text-base">Queue Ticket</DialogTitle>
                        <DialogDescription className="sr-only">Print the queue ticket for the donor.</DialogDescription>
                    </DialogHeader>

                    <div className="flex flex-col items-center gap-3 py-4">
                        <div className="text-center">
                            <p className="text-xs text-muted-foreground uppercase tracking-wider">{receiptData?.event_name}</p>
                        </div>
                        <div className="border-b border-dashed w-full" />
                        <div className="text-center">
                            <p className="text-xs text-muted-foreground">Donor</p>
                            <p className="text-xl font-semibold">{receiptData?.donor_name}</p>
                        </div>
                        <p className="text-xs text-muted-foreground">
                            {new Date().toLocaleDateString()} {new Date().toLocaleTimeString()}
                        </p>
                    </div>

                    <DialogFooter className="sm:justify-center gap-2">
                        <Button onClick={handlePrint} disabled={checkingIn} className="w-full sm:w-auto">
                            {checkingIn ? 'Checking in...' : 'Print Ticket'}
                        </Button>
                        <DialogClose asChild>
                            <Button variant="outline" disabled={checkingIn} className="w-full sm:w-auto">Cancel</Button>
                        </DialogClose>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            <style>{`
                @media print {
                    body > *:not(#print-receipt-print) { display: none !important; }
                    #print-receipt-print { display: flex !important; align-items: center !important; justify-content: center !important; min-height: 100vh !important; }
                }
            `}</style>
        </>
    );
}
