import { Head } from '@inertiajs/react';
import { useForm, router } from '@inertiajs/react';
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
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import admin from '@/routes/admin';

interface Department {
    id: number;
    name: string;
}

interface Course {
    id: number;
    name: string;
    department: Department | null;
}

interface Props {
    courses: Course[];
    departments: Department[];
}

function AddCourseForm({ departments, onSuccess }: { departments: Department[]; onSuccess: () => void }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        department_id: '',
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        post(admin.courses.store().url, {
            onSuccess: () => {
                reset();
                onSuccess();
            },
        });
    }

    return (
        <form onSubmit={handleSubmit} className="mb-4 rounded-lg border bg-muted/30 p-4">
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div className="space-y-2">
                    <Label htmlFor="course-name">Course Name</Label>
                    <Input id="course-name" placeholder="Course name" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                    {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
                </div>
                <div className="space-y-2">
                    <Label htmlFor="course-dept">Department</Label>
                    <select
                        id="course-dept"
                        value={data.department_id}
                        onChange={(e) => setData('department_id', e.target.value)}
                        className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-colors focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 outline-none md:text-sm"
                    >
                        <option value="">Select department</option>
                        {departments.map((d) => (
                            <option key={d.id} value={d.id}>{d.name}</option>
                        ))}
                    </select>
                    {errors.department_id && <p className="text-sm text-destructive">{errors.department_id}</p>}
                </div>
                <div className="flex items-end">
                    <Button type="submit" disabled={processing}>
                        {processing ? 'Adding...' : 'Add Course'}
                    </Button>
                </div>
            </div>
        </form>
    );
}

function EditCourseDialog({
    course,
    departments,
    open,
    onOpenChange,
    onSuccess,
}: {
    course: Course;
    departments: Department[];
    open: boolean;
    onOpenChange: (open: boolean) => void;
    onSuccess: () => void;
}) {
    const { data, setData, put, processing, errors } = useForm({
        name: course.name,
        department_id: String(course.department?.id ?? ''),
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        put(admin.courses.update(course.id).url, {
            onSuccess: () => {
                onSuccess();
                onOpenChange(false);
            },
        });
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Edit Course</DialogTitle>
                    <DialogDescription>Update the details for {course.name}.</DialogDescription>
                </DialogHeader>
                <form onSubmit={handleSubmit}>
                    <div className="space-y-4 py-4">
                        <div className="space-y-2">
                            <Label htmlFor="edit-name">Course Name</Label>
                            <Input id="edit-name" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                            {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="edit-dept">Department</Label>
                            <select
                                id="edit-dept"
                                value={data.department_id}
                                onChange={(e) => setData('department_id', e.target.value)}
                                className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-colors focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 outline-none md:text-sm"
                            >
                                <option value="">Select department</option>
                                {departments.map((d) => (
                                    <option key={d.id} value={d.id}>{d.name}</option>
                                ))}
                            </select>
                            {errors.department_id && <p className="text-sm text-destructive">{errors.department_id}</p>}
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline">Cancel</Button>
                        </DialogClose>
                        <Button type="submit" disabled={processing}>
                            {processing ? 'Saving...' : 'Save Changes'}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

function DeleteCourseDialog({
    course,
    open,
    onOpenChange,
}: {
    course: Course;
    open: boolean;
    onOpenChange: (open: boolean) => void;
}) {
    const [processing, setProcessing] = useState(false);

    function handleDelete() {
        setProcessing(true);
        router.delete(admin.courses.destroy(course.id).url, {
            onFinish: () => setProcessing(false),
        });
        onOpenChange(false);
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete Course</DialogTitle>
                    <DialogDescription>
                        Are you sure you want to delete "{course.name}"? This action cannot be undone.
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

export default function CoursesIndex({ courses, departments }: Props) {
    const [editingCourse, setEditingCourse] = useState<Course | null>(null);
    const [deletingCourse, setDeletingCourse] = useState<Course | null>(null);
    const [showAddForm, setShowAddForm] = useState(false);

    return (
        <>
            <Head title="Courses" />
            <div className="p-6">
                <h1 className="mb-6 text-2xl font-bold">Courses</h1>

                <div className="mb-4">
                    <Button onClick={() => setShowAddForm(!showAddForm)} variant={showAddForm ? 'outline' : 'default'}>
                        {showAddForm ? 'Cancel' : 'Add Course'}
                    </Button>
                </div>

                {showAddForm && (
                    <AddCourseForm departments={departments} onSuccess={() => setShowAddForm(false)} />
                )}

                <div className="rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Department</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {courses.map((course) => (
                                <TableRow key={course.id}>
                                    <TableCell className="font-medium">{course.name}</TableCell>
                                    <TableCell className="text-muted-foreground">{course.department?.name ?? '—'}</TableCell>
                                    <TableCell className="text-right">
                                        <Button onClick={() => setEditingCourse(course)} variant="ghost" size="sm" className="mr-2">Edit</Button>
                                        <Button onClick={() => setDeletingCourse(course)} variant="ghost" size="sm" className="text-destructive">Delete</Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            </div>

            {editingCourse && (
                <EditCourseDialog
                    course={editingCourse}
                    departments={departments}
                    open={!!editingCourse}
                    onOpenChange={(open) => {
 if (!open) {
setEditingCourse(null);
} 
}}
                    onSuccess={() => router.reload({ only: ['courses'] })}
                />
            )}

            {deletingCourse && (
                <DeleteCourseDialog
                    course={deletingCourse}
                    open={!!deletingCourse}
                    onOpenChange={(open) => {
 if (!open) {
setDeletingCourse(null);
} 
}}
                />
            )}
        </>
    );
}
