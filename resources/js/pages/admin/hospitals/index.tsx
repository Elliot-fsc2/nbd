import { Head, Link } from '@inertiajs/react';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
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

interface Hospital {
    id: number;
    name: string;
    code: string;
    donors_count: number;
}

interface Props {
    hospitals: Hospital[];
}

function DeleteHospitalDialog({
    hospital,
    open,
    onOpenChange,
}: {
    hospital: Hospital;
    open: boolean;
    onOpenChange: (open: boolean) => void;
}) {
    const [processing, setProcessing] = useState(false);

    function handleDelete() {
        setProcessing(true);
        router.delete(admin.hospitals.destroy(hospital.id).url, {
            onFinish: () => setProcessing(false),
        });
        onOpenChange(false);
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete Hospital</DialogTitle>
                    <DialogDescription>
                        Are you sure you want to delete "{hospital.name}"? This action cannot be undone.
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

export default function HospitalsIndex({ hospitals }: Props) {
    const [deletingHospital, setDeletingHospital] = useState<Hospital | null>(null);

    return (
        <>
            <Head title="Hospitals" />
            <div className="p-6">
                <div className="mb-6 flex items-center justify-between">
                    <h1 className="text-2xl font-bold">Hospitals</h1>
                    <Link href={admin.hospitals.create().url}>
                        <Button>Add Hospital</Button>
                    </Link>
                </div>

                <div className="rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Code</TableHead>
                                <TableHead>Donors</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {hospitals.map((hospital) => (
                                <TableRow key={hospital.id}>
                                    <TableCell className="font-medium">{hospital.name}</TableCell>
                                    <TableCell className="text-muted-foreground">{hospital.code}</TableCell>
                                    <TableCell className="text-muted-foreground">{hospital.donors_count}</TableCell>
                                    <TableCell className="text-right">
                                        <Link href={admin.hospitals.edit(hospital.id).url} className="mr-3 text-sm text-muted-foreground hover:text-foreground">
                                            Edit
                                        </Link>
                                        <Button onClick={() => setDeletingHospital(hospital)} variant="ghost" size="sm" className="text-destructive">
                                            Delete
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            </div>

            {deletingHospital && (
                <DeleteHospitalDialog
                    hospital={deletingHospital}
                    open={!!deletingHospital}
                    onOpenChange={(open) => {
 if (!open) {
setDeletingHospital(null);
} 
}}
                />
            )}
        </>
    );
}
