import { format } from 'date-fns';
import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { DateRangePicker } from '@/components/ui/date-range-picker';
import type { DateRange } from 'react-day-picker';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Textarea } from '@/components/ui/textarea';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import staff from '@/routes/staff';

interface Hospital {
    id: number;
    name: string;
    code: string;
}

interface SelectOption {
    value: string;
    label: string;
}

interface Donor {
    id: number;
    tracking_code: string;
    donor_type: string;
    full_name: string;
    id_number: string | null;
    email: string;
    contact_number: string | null;
    status: string | null;
    outcome_status: string | null;
    staff_remarks: string | null;
    checked_in_at: string | null;
    called_at: string | null;
    completed_at: string | null;
    checked_in_time: string | null;
    called_time: string | null;
    completed_time: string | null;
    course_name: string | null;
    created_at: string | null;
    house_heroes_label: string | null;
    representative_for: string | null;
    hospital_name: string | null;
    data: Record<string, string> | null;
}

interface PaginatedData<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    donors: PaginatedData<Donor>;
    hospitals: Hospital[];
    statuses: SelectOption[];
    outcomeStatuses: SelectOption[];
    houseOptions: SelectOption[];
    filters: {
        search?: string;
        hospital_id?: string;
        status?: string;
        outcome_status?: string;
        house?: string;
        date_from?: string;
        date_to?: string;
    };
}

const donorTypeLabels: Record<string, string> = {
    student: 'Student',
    employee: 'Employee',
    representative: 'Representative',
};

const outcomeLabels: Record<string, string> = {
    completed: 'Completed',
    rescheduled: 'Rescheduled',
    not_completed: 'Not Completed',
};

const statusLabels: Record<string, string> = {
    registered: 'Registered',
    checked_in: 'Checked In',
    in_progress: 'In Progress',
    completed: 'Completed',
    skipped: 'Skipped',
};

function DonorEditDialog({ donor, open, onOpenChange }: { donor: Donor | null; open: boolean; onOpenChange: (open: boolean) => void }) {
    const [outcomeStatus, setOutcomeStatus] = useState(donor?.outcome_status ?? '');
    const [staffRemarks, setStaffRemarks] = useState(donor?.staff_remarks ?? '');
    const [saving, setSaving] = useState(false);

    if (!donor) return null;

    const d = donor.data ?? {};

    const fields: [string, string | undefined | null][] = [
        ['Tracking Code', donor.tracking_code],
        ['Registered', donor.created_at ? format(donor.created_at, 'MMM d, yyyy h:mm a') : undefined],
        ['Outcome Status', donor.outcome_status ? outcomeLabels[donor.outcome_status] ?? donor.outcome_status : 'Not set'],
        ['Check-in Time', donor.checked_in_at],
        ['Call Time', donor.called_at],
        ['Completion Time', donor.completed_at],
        ['Full Name', donor.full_name],
        ['Donor Type', donor.donor_type ? donorTypeLabels[donor.donor_type] ?? donor.donor_type : undefined],
        ['Surname', d.surname],
        ['Given Name', d.given_name],
        ['Middle Name', d.middle_name],
        ['Birthdate', d.birthdate],
        ['Age', d.age],
        ['Sex', d.sex ? (d.sex === 'male' ? 'Male' : 'Female') : undefined],
        ['Blood Type', d.blood_type],
        ['Occupation', d.occupation],
        ['Civil Status', d.civil_status ? d.civil_status.charAt(0).toUpperCase() + d.civil_status.slice(1) : undefined],
        ['Student/Employee ID', donor.id_number ?? d.id_number],
        ['House of Heroes', donor.house_heroes_label],
        ['Course', donor.course_name ?? d.course_id],
        ['Year & Section', d.year_section],
        ['Instructor Name', d.instructor_name],
        ['Representative For', d.representative_full_name],
        ['House No', d.house_no],
        ['Street', d.street],
        ['Subdivision', d.subdivision],
        ['Barangay', d.barangay],
        ['City/Province', d.city_province],
        ['Email', donor.email],
        ['Contact Number', donor.contact_number],
    ];

    function handleSave() {
        setSaving(true);
        router.put(staff.donors.update(donor.id).url, {
            outcome_status: outcomeStatus || null,
            staff_remarks: staffRemarks || null,
        }, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => onOpenChange(false),
            onFinish: () => setSaving(false),
        });
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="max-w-2xl max-h-[85vh] overflow-y-auto">
                <DialogHeader>
                    <DialogTitle>{donor.full_name}</DialogTitle>
                </DialogHeader>

                <div className="space-y-1">
                    {fields.map(([label, value]) => (
                        value ? (
                            <div key={label} className="flex justify-between border-b border-gray-100 py-1.5 text-sm">
                                <span className="text-muted-foreground">{label}</span>
                                <span className="font-medium text-right max-w-[60%]">{value}</span>
                            </div>
                        ) : null
                    ))}
                </div>

                <div className="mt-4 space-y-4 border-t pt-4">
                    <div className="space-y-2">
                        <Label htmlFor="outcome_status">Status</Label>
                        <Select value={outcomeStatus} onValueChange={setOutcomeStatus}>
                            <SelectTrigger id="outcome_status">
                                <SelectValue placeholder="Select status..." />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="completed">Completed</SelectItem>
                                <SelectItem value="rescheduled">Rescheduled</SelectItem>
                                <SelectItem value="not_completed">Not Completed</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="staff_remarks">Remarks</Label>
                        <Textarea
                            id="staff_remarks"
                            value={staffRemarks}
                            onChange={(e) => setStaffRemarks(e.target.value)}
                            placeholder="Add remarks..."
                            rows={3}
                        />
                    </div>

                    <Button onClick={handleSave} disabled={saving} className="w-full">
                        {saving ? 'Saving...' : 'Save Status'}
                    </Button>
                </div>

                {donor.hospital_name && !donor.hospital_name.toLowerCase().includes('luk') && (
                    <div className="mt-4 flex gap-2">
                        <a
                            href={staff.donors.form(donor.id)?.url || `/staff/donors/${donor.id}/form`}
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <Button variant="default">Download Form</Button>
                        </a>
                    </div>
                )}
            </DialogContent>
        </Dialog>
    );
}

export default function DonorsIndex({ donors, hospitals, statuses, outcomeStatuses, houseOptions, filters }: Props) {
    const [search, setSearch] = useState(filters.search ?? '');
    const [hospitalId, setHospitalId] = useState(filters.hospital_id ?? '');
    const [statusFilter, setStatusFilter] = useState(filters.status ?? '');
    const [houseFilter, setHouseFilter] = useState(filters.house ?? '');
    const [outcomeFilter, setOutcomeFilter] = useState(filters.outcome_status ?? '');
    const [selectedDonor, setSelectedDonor] = useState<Donor | null>(null);

    const [dateRange, setDateRange] = useState<DateRange | undefined>(
        filters.date_from || filters.date_to
            ? {
                  from: filters.date_from ? new Date(filters.date_from) : undefined,
                  to: filters.date_to ? new Date(filters.date_to) : undefined,
              }
            : undefined,
    );

    const hasActiveFilters = !!(filters.search || filters.status || filters.outcome_status || filters.hospital_id || filters.house || filters.date_from || filters.date_to);

    function applyFilters() {
        router.visit(staff.donors.index().url, {
            data: {
                search: search || undefined,
                hospital_id: hospitalId || undefined,
                status: statusFilter || undefined,
                outcome_status: outcomeFilter || undefined,
                house: houseFilter || undefined,
                date_from: dateRange?.from ? format(dateRange.from, 'yyyy-MM-dd') : undefined,
                date_to: dateRange?.to ? format(dateRange.to, 'yyyy-MM-dd') : undefined,
            },
            preserveState: true,
            preserveScroll: true,
        });
    }

    function handleSearch(e: React.FormEvent) {
        e.preventDefault();
        applyFilters();
    }

    function clearFilters() {
        setSearch('');
        setStatusFilter('');
        setOutcomeFilter('');
        setHospitalId('');
        setHouseFilter('');
        setDateRange(undefined);
        router.visit(staff.donors.index().url, {
            preserveState: true,
            preserveScroll: true,
        });
    }

    return (
        <>
            <Head title="Donors" />
            <div className="p-6">
                <h1 className="mb-6 text-2xl font-bold">Donors</h1>

                <form onSubmit={handleSearch} className="mb-4">
                    <div className="rounded-lg border bg-card p-3">
                        <div className="flex flex-wrap items-end gap-2">
                            <div className="flex min-w-0 flex-1 basis-[200px] gap-2">
                                <div className="relative flex-1">
                                    <Input
                                        type="text"
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        placeholder="Search by name, ID, email..."
                                        className="pr-20"
                                    />
                                    <Button
                                        type="submit"
                                        size="sm"
                                        className="absolute right-1 top-1/2 -translate-y-1/2 h-7 text-xs"
                                    >
                                        Search
                                    </Button>
                                </div>
                            </div>
                            <Select value={hospitalId} onValueChange={(v) => {
                                const val = v === ' ' ? '' : v;
                                setHospitalId(val);
                                router.visit(staff.donors.index().url, {
                                    data: {
                                        search: search || undefined,
                                        hospital_id: val || undefined,
                                        status: statusFilter || undefined,
                                        outcome_status: outcomeFilter || undefined,
                                        house: houseFilter || undefined,
                                        date_from: dateRange?.from ? format(dateRange.from, 'yyyy-MM-dd') : undefined,
                                        date_to: dateRange?.to ? format(dateRange.to, 'yyyy-MM-dd') : undefined,
                                    },
                                    preserveState: true,
                                    preserveScroll: true,
                                });
                            }}>
                                <SelectTrigger className="w-[180px]">
                                    <SelectValue placeholder="Hospital" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value=" ">All Hospitals</SelectItem>
                                    {hospitals.map((hospital) => (
                                        <SelectItem key={hospital.id} value={String(hospital.id)}>
                                            {hospital.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <Select value={statusFilter} onValueChange={(v) => {
                                const val = v === ' ' ? '' : v;
                                setStatusFilter(val);
                                router.visit(staff.donors.index().url, {
                                    data: {
                                        search: search || undefined,
                                        hospital_id: hospitalId || undefined,
                                        status: val || undefined,
                                        outcome_status: outcomeFilter || undefined,
                                        house: houseFilter || undefined,
                                        date_from: dateRange?.from ? format(dateRange.from, 'yyyy-MM-dd') : undefined,
                                        date_to: dateRange?.to ? format(dateRange.to, 'yyyy-MM-dd') : undefined,
                                    },
                                    preserveState: true,
                                    preserveScroll: true,
                                });
                            }}>
                                <SelectTrigger className="w-[150px]">
                                    <SelectValue placeholder="Status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value=" ">All Status</SelectItem>
                                    {statuses.map((s) => (
                                        <SelectItem key={s.value} value={s.value}>
                                            {s.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <Select value={outcomeFilter} onValueChange={(v) => {
                                const val = v === ' ' ? '' : v;
                                setOutcomeFilter(val);
                                router.visit(staff.donors.index().url, {
                                    data: {
                                        search: search || undefined,
                                        hospital_id: hospitalId || undefined,
                                        status: statusFilter || undefined,
                                        outcome_status: val || undefined,
                                        house: houseFilter || undefined,
                                        date_from: dateRange?.from ? format(dateRange.from, 'yyyy-MM-dd') : undefined,
                                        date_to: dateRange?.to ? format(dateRange.to, 'yyyy-MM-dd') : undefined,
                                    },
                                    preserveState: true,
                                    preserveScroll: true,
                                });
                            }}>
                                <SelectTrigger className="w-[150px]">
                                    <SelectValue placeholder="Outcome" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value=" ">All Outcomes</SelectItem>
                                    {outcomeStatuses.map((s) => (
                                        <SelectItem key={s.value} value={s.value}>
                                            {s.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <Select value={houseFilter} onValueChange={(v) => {
                                const val = v === ' ' ? '' : v;
                                setHouseFilter(val);
                                router.visit(staff.donors.index().url, {
                                    data: {
                                        search: search || undefined,
                                        hospital_id: hospitalId || undefined,
                                        status: statusFilter || undefined,
                                        outcome_status: outcomeFilter || undefined,
                                        house: val || undefined,
                                        date_from: dateRange?.from ? format(dateRange.from, 'yyyy-MM-dd') : undefined,
                                        date_to: dateRange?.to ? format(dateRange.to, 'yyyy-MM-dd') : undefined,
                                    },
                                    preserveState: true,
                                    preserveScroll: true,
                                });
                            }}>
                                <SelectTrigger className="w-[150px]">
                                    <SelectValue placeholder="House" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value=" ">All Houses</SelectItem>
                                    {houseOptions.map((h) => (
                                        <SelectItem key={h.value} value={h.value}>
                                            {h.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <DateRangePicker
                                value={dateRange}
                                onChange={(range) => {
                                    setDateRange(range);
                                    if (range?.from && range?.to) {
                                        router.visit(staff.donors.index().url, {
                                            data: {
                                                search: search || undefined,
                                                hospital_id: hospitalId || undefined,
                                                status: statusFilter || undefined,
                                                outcome_status: outcomeFilter || undefined,
                                                house: houseFilter || undefined,
                                                date_from: format(range.from, 'yyyy-MM-dd'),
                                                date_to: format(range.to, 'yyyy-MM-dd'),
                                            },
                                            preserveState: true,
                                            preserveScroll: true,
                                        });
                                    }
                                }}
                            />
                            <div className="flex items-center gap-1">
                                {hasActiveFilters && (
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        onClick={clearFilters}
                                        className="text-muted-foreground hover:text-foreground"
                                    >
                                        <svg className="mr-1 size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Clear
                                    </Button>
                                )}
                                <a
                                    href={staff.donors.export().url + '?' + new URLSearchParams({
                                        ...(filters.search ? { search: filters.search } : {}),
                                        ...(filters.hospital_id ? { hospital_id: filters.hospital_id } : {}),
                                        ...(filters.status ? { status: filters.status } : {}),
                                        ...(filters.outcome_status ? { outcome_status: filters.outcome_status } : {}),
                                        ...(filters.house ? { house: filters.house } : {}),
                                        ...(filters.date_from ? { date_from: filters.date_from } : {}),
                                        ...(filters.date_to ? { date_to: filters.date_to } : {}),
                                    }).toString()}
                                >
                                    <Button variant="outline" size="sm" type="button">
                                        <svg className="mr-1.5 size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Export
                                    </Button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div className="rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Full Name</TableHead>
                                <TableHead>Registered</TableHead>
                                <TableHead>Assigned Hospital</TableHead>
                                <TableHead>ID Number</TableHead>
                                <TableHead>Type</TableHead>
                                <TableHead>Representing</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Contact</TableHead>
                                <TableHead>Check-in</TableHead>
                                <TableHead>Called</TableHead>
                                <TableHead>Completed</TableHead>
                                <TableHead>House</TableHead>
                                <TableHead>Status</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {donors.data.length === 0 ? (
                                <TableRow>
                                    <TableCell colSpan={13} className="text-center text-muted-foreground">
                                        No donors found.
                                    </TableCell>
                                </TableRow>
                            ) : (
                                donors.data.map((donor) => (
                                    <TableRow
                                        key={donor.id}
                                        className="cursor-pointer"
                                        onClick={() => {
                                            setSelectedDonor(donor);
                                            setSearch('');
                                        }}
                                    >
                                        <TableCell className="font-medium">{donor.full_name}</TableCell>
                                        <TableCell className="text-muted-foreground text-xs whitespace-nowrap">{donor.created_at ? format(donor.created_at, 'MMM d, yyyy h:mm a') : '-'}</TableCell>
                                        <TableCell className="text-muted-foreground text-xs">{donor.hospital_name ?? '-'}</TableCell>
                                        <TableCell className="text-muted-foreground text-xs">{donor.id_number ?? '-'}</TableCell>
                                        <TableCell>
                                            <span className="inline-flex items-center rounded-full bg-purple-50 px-2 py-0.5 text-xs font-medium text-purple-700">
                                                {donorTypeLabels[donor.donor_type] ?? donor.donor_type}
                                            </span>
                                        </TableCell>
                                        <TableCell className="text-muted-foreground text-xs">{donor.representative_for ?? '-'}</TableCell>
                                        <TableCell className="text-muted-foreground">{donor.email}</TableCell>
                                        <TableCell className="text-muted-foreground">{donor.contact_number ?? '-'}</TableCell>
                                        <TableCell className="text-muted-foreground text-xs whitespace-nowrap">{donor.checked_in_time ?? '-'}</TableCell>
                                        <TableCell className="text-muted-foreground text-xs whitespace-nowrap">{donor.called_time ?? '-'}</TableCell>
                                        <TableCell className="text-muted-foreground text-xs whitespace-nowrap">{donor.completed_time ?? '-'}</TableCell>
                                        <TableCell>
                                            {donor.house_heroes_label ? (
                                                <span className="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">
                                                    {donor.house_heroes_label}
                                                </span>
                                            ) : '-'}
                                        </TableCell>
                                        <TableCell>
                                            {donor.status ? (
                                                <span className="inline-flex items-center rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700">
                                                    {statusLabels[donor.status] ?? donor.status}
                                                </span>
                                            ) : donor.outcome_status ? (
                                                <span className="inline-flex items-center rounded-full bg-orange-50 px-2 py-0.5 text-xs font-medium text-orange-700">
                                                    {outcomeLabels[donor.outcome_status] ?? donor.outcome_status}
                                                </span>
                                            ) : (
                                                <span className="text-muted-foreground text-xs">Not set</span>
                                            )}
                                        </TableCell>
                                    </TableRow>
                                ))
                            )}
                        </TableBody>
                    </Table>
                </div>

                {donors.last_page > 1 && (
                    <div className="mt-4 flex items-center justify-between">
                        <p className="text-sm text-muted-foreground">
                            Showing {donors.data.length} of {donors.total} donors
                        </p>
                        <div className="flex gap-2">
                            {donors.current_page > 1 && (
                                <Link
                                    href={staff.donors.index().url}
                                    data={{ page: donors.current_page - 1, search: filters.search, hospital_id: filters.hospital_id, status: filters.status, outcome_status: filters.outcome_status, house: filters.house, date_from: filters.date_from, date_to: filters.date_to }}
                                    preserveState
                                    preserveScroll
                                >
                                    <Button variant="outline" size="sm">Previous</Button>
                                </Link>
                            )}
                            {donors.current_page < donors.last_page && (
                                <Link
                                    href={staff.donors.index().url}
                                    data={{ page: donors.current_page + 1, search: filters.search, hospital_id: filters.hospital_id, status: filters.status, outcome_status: filters.outcome_status, house: filters.house, date_from: filters.date_from, date_to: filters.date_to }}
                                    preserveState
                                    preserveScroll
                                >
                                    <Button variant="outline" size="sm">Next</Button>
                                </Link>
                            )}
                        </div>
                    </div>
                )}
            </div>

            <DonorEditDialog
                donor={selectedDonor}
                open={!!selectedDonor}
                onOpenChange={(open) => { if (!open) setSelectedDonor(null); }}
            />
        </>
    );
}
