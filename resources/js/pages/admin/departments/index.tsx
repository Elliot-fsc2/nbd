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

interface Department {
    id: number;
    name: string;
    courses_count: number;
}

interface Props {
    departments: Department[];
}

function DeleteDepartmentDialog({
    department,
    open,
    onOpenChange,
}: {
    department: Department;
    open: boolean;
    onOpenChange: (open: boolean) => void;
}) {
    const [processing, setProcessing] = useState(false);

    function handleDelete() {
        setProcessing(true);
        router.delete(admin.departments.destroy(department.id).url, {
            onFinish: () => setProcessing(false),
        });
        onOpenChange(false);
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete Department</DialogTitle>
                    <DialogDescription>
                        Are you sure you want to delete "{department.name}"? This action cannot be undone.
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

export default function DepartmentsIndex({ departments }: Props) {
    const [deletingDepartment, setDeletingDepartment] = useState<Department | null>(null);

    return (
        <>
            <Head title="Departments" />
            <div className="p-6">
                <div className="mb-6 flex items-center justify-between">
                    <h1 className="text-2xl font-bold">Departments</h1>
                    <Link href={admin.departments.create().url}>
                        <Button>Add Department</Button>
                    </Link>
                </div>

                <div className="rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Courses</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {departments.map((department) => (
                                <TableRow key={department.id}>
                                    <TableCell className="font-medium">{department.name}</TableCell>
                                    <TableCell className="text-muted-foreground">{department.courses_count}</TableCell>
                                    <TableCell className="text-right">
                                        <Link href={admin.departments.edit(department.id).url} className="mr-3 text-sm text-muted-foreground hover:text-foreground">
                                            Edit
                                        </Link>
                                        <Button onClick={() => setDeletingDepartment(department)} variant="ghost" size="sm" className="text-destructive">
                                            Delete
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            </div>

            {deletingDepartment && (
                <DeleteDepartmentDialog
                    department={deletingDepartment}
                    open={!!deletingDepartment}
                    onOpenChange={(open) => {
 if (!open) {
setDeletingDepartment(null);
} 
}}
                />
            )}
        </>
    );
}
