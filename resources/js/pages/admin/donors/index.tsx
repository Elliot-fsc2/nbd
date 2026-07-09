import { Head, Link } from '@inertiajs/react';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import admin from '@/routes/admin';

interface Donor {
    id: number;
    surname: string;
    given_name: string;
    blood_type: string;
    email: string;
    contact_number: string | null;
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

export default function DonorsIndex({ donors, filters }: Props) {
    const [search, setSearch] = useState(filters.search ?? '');

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
                                    <TableRow key={donor.id}>
                                        <TableCell className="font-medium">{donor.surname}, {donor.given_name}</TableCell>
                                        <TableCell className="text-muted-foreground">{donor.blood_type}</TableCell>
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
        </>
    );
}
