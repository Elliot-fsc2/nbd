import { Head, Link } from '@inertiajs/react';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import admin from '@/routes/admin';

interface Donor {
    id: number;
    tracking_code: string;
    full_name: string;
    donor_type: string | null;
    id_number: string | null;
    email: string;
    contact_number: string | null;
    status: string | null;
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
    filters: {
        search?: string;
    };
}

const statusLabels: Record<string, string> = {
    registered: 'Registered',
    checked_in: 'Checked In',
    in_progress: 'In Progress',
    completed: 'Completed',
    skipped: 'Skipped',
};

const donorTypeLabels: Record<string, string> = {
    student: 'Student',
    employee: 'Employee',
    representative: 'Representative',
};

function DonorDetailDialog({ donor, open, onOpenChange }: { donor: Donor | null; open: boolean; onOpenChange: (open: boolean) => void }) {
    if (!donor) return null;

    const d = donor.data ?? {};

    const fields: [string, string | undefined | null][] = [
        ['Tracking Code', donor.tracking_code],
        ['Status', donor.status ? statusLabels[donor.status] ?? donor.status : undefined],
        ['Donor Type', donor.donor_type ? donorTypeLabels[donor.donor_type] ?? donor.donor_type : undefined],
        ['Full Name', donor.full_name],
        ['Surname', d.surname],
        ['Given Name', d.given_name],
        ['Middle Name', d.middle_name],
        ['Birthdate', d.birthdate],
        ['Age', d.age],
        ['Sex', d.sex ? (d.sex === 'male' ? 'Male' : 'Female') : undefined],
        ['Civil Status', d.civil_status ? d.civil_status.charAt(0).toUpperCase() + d.civil_status.slice(1) : undefined],
        ['Blood Type', d.blood_type],
        ['Occupation', d.occupation],
        ['Assigned Hospital', donor.hospital_name],
        ['Student/Employee ID', donor.id_number ?? d.id_number],
        ['House of Heroes', d.house_heroes ? d.house_heroes.charAt(0).toUpperCase() + d.house_heroes.slice(1) : undefined],
        ['Course ID', d.course_id],
        ['Year & Section', d.year_section],
        ['Representative For', d.representative_full_name],
        ['House No', d.house_no],
        ['Street', d.street],
        ['Subdivision', d.subdivision],
        ['Barangay', d.barangay],
        ['City/Province', d.city_province],
        ['Email', donor.email],
        ['Contact Number', donor.contact_number],
    ];

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

                <div className="mt-4 flex gap-2">
                    <a
                        href={admin.donors.form(donor.id)?.url || `/admin/donors/${donor.id}/form`}
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <Button variant="default">Download Form</Button>
                    </a>
                </div>
            </DialogContent>
        </Dialog>
    );
}

export default function DonorsIndex({ donors, filters }: Props) {
    const [search, setSearch] = useState(filters.search ?? '');
    const [selectedDonor, setSelectedDonor] = useState<Donor | null>(null);

    function handleSearch(e: React.FormEvent) {
        e.preventDefault();
        router.visit(admin.donors.index().url, {
            data: { search },
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

                <div className="rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Full Name</TableHead>
                                <TableHead>Blood Type</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Contact</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {donors.data.length === 0 ? (
                                <TableRow>
                                    <TableCell colSpan={4} className="text-center text-muted-foreground">
                                        No donors found.
                                    </TableCell>
                                </TableRow>
                            ) : (
                                donors.data.map((donor) => (
                                    <TableRow
                                        key={donor.id}
                                        className="cursor-pointer"
                                        onClick={() => setSelectedDonor(donor)}
                                    >
                                        <TableCell className="font-medium">{donor.full_name}</TableCell>
                                        <TableCell className="text-muted-foreground">{donor.data?.blood_type ?? '-'}</TableCell>
                                        <TableCell className="text-muted-foreground">{donor.email}</TableCell>
                                        <TableCell className="text-muted-foreground">{donor.contact_number ?? '-'}</TableCell>
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
                                    href={admin.donors.index().url}
                                    data={{ page: donors.current_page - 1, search: filters.search }}
                                    preserveState
                                    preserveScroll
                                >
                                    <Button variant="outline" size="sm">Previous</Button>
                                </Link>
                            )}
                            {donors.current_page < donors.last_page && (
                                <Link
                                    href={admin.donors.index().url}
                                    data={{ page: donors.current_page + 1, search: filters.search }}
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

            <DonorDetailDialog
                donor={selectedDonor}
                open={!!selectedDonor}
                onOpenChange={(open) => { if (!open) setSelectedDonor(null); }}
            />
        </>
    );
}
