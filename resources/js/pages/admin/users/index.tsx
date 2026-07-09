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

interface User {
    id: number;
    name: string;
    email: string;
}

interface Props {
    users: User[];
}

function AddUserForm({ onSuccess }: { onSuccess: () => void }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        post(admin.users.store().url, {
            onSuccess: () => {
                reset();
                onSuccess();
            },
        });
    }

    return (
        <form onSubmit={handleSubmit} className="mb-4 rounded-lg border bg-muted/30 p-4">
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div className="space-y-2">
                    <Label htmlFor="add-name">Name</Label>
                    <Input id="add-name" placeholder="Name" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                    {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
                </div>
                <div className="space-y-2">
                    <Label htmlFor="add-email">Email</Label>
                    <Input id="add-email" type="email" placeholder="Email" value={data.email} onChange={(e) => setData('email', e.target.value)} />
                    {errors.email && <p className="text-sm text-destructive">{errors.email}</p>}
                </div>
                <div className="space-y-2">
                    <Label htmlFor="add-password">Password</Label>
                    <Input id="add-password" type="password" placeholder="Password" value={data.password} onChange={(e) => setData('password', e.target.value)} />
                    {errors.password && <p className="text-sm text-destructive">{errors.password}</p>}
                </div>
                <div className="flex items-end">
                    <Button type="submit" disabled={processing}>
                        {processing ? 'Adding...' : 'Add User'}
                    </Button>
                </div>
            </div>
        </form>
    );
}

function EditUserDialog({
    user,
    open,
    onOpenChange,
    onSuccess,
}: {
    user: User;
    open: boolean;
    onOpenChange: (open: boolean) => void;
    onSuccess: () => void;
}) {
    const { data, setData, put, processing, errors } = useForm({
        name: user.name,
        email: user.email,
        password: '',
        password_confirmation: '',
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        put(admin.users.update(user.id).url, {
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
                    <DialogTitle>Edit User</DialogTitle>
                    <DialogDescription>Update the details for {user.name}.</DialogDescription>
                </DialogHeader>
                <form onSubmit={handleSubmit}>
                    <div className="space-y-4 py-4">
                        <div className="space-y-2">
                            <Label htmlFor="edit-name">Name</Label>
                            <Input id="edit-name" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                            {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="edit-email">Email</Label>
                            <Input id="edit-email" type="email" value={data.email} onChange={(e) => setData('email', e.target.value)} />
                            {errors.email && <p className="text-sm text-destructive">{errors.email}</p>}
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="edit-password">New Password (optional)</Label>
                            <Input id="edit-password" type="password" value={data.password} onChange={(e) => setData('password', e.target.value)} />
                            {errors.password && <p className="text-sm text-destructive">{errors.password}</p>}
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

function DeleteUserDialog({
    user,
    open,
    onOpenChange,
}: {
    user: User;
    open: boolean;
    onOpenChange: (open: boolean) => void;
}) {
    const [processing, setProcessing] = useState(false);

    function handleDelete() {
        setProcessing(true);
        router.delete(admin.users.destroy(user.id).url, {
            onFinish: () => setProcessing(false),
        });
        onOpenChange(false);
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete User</DialogTitle>
                    <DialogDescription>
                        Are you sure you want to delete "{user.name}"? This action cannot be undone.
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

export default function UsersIndex({ users }: Props) {
    const [editingUser, setEditingUser] = useState<User | null>(null);
    const [deletingUser, setDeletingUser] = useState<User | null>(null);
    const [showAddForm, setShowAddForm] = useState(false);

    return (
        <>
            <Head title="Users" />
            <div className="p-6">
                <h1 className="mb-6 text-2xl font-bold">Users</h1>

                <div className="mb-4">
                    <Button onClick={() => setShowAddForm(!showAddForm)} variant={showAddForm ? 'outline' : 'default'}>
                        {showAddForm ? 'Cancel' : 'Add User'}
                    </Button>
                </div>

                {showAddForm && (
                    <AddUserForm onSuccess={() => setShowAddForm(false)} />
                )}

                <div className="rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {users.map((user) => (
                                <TableRow key={user.id}>
                                    <TableCell className="font-medium">{user.name}</TableCell>
                                    <TableCell className="text-muted-foreground">{user.email}</TableCell>
                                    <TableCell className="text-right">
                                        <Button onClick={() => setEditingUser(user)} variant="ghost" size="sm" className="mr-2">Edit</Button>
                                        <Button onClick={() => setDeletingUser(user)} variant="ghost" size="sm" className="text-destructive">Delete</Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            </div>

            {editingUser && (
                <EditUserDialog
                    user={editingUser}
                    open={!!editingUser}
                    onOpenChange={(open) => {
 if (!open) {
setEditingUser(null);
} 
}}
                    onSuccess={() => router.reload({ only: ['users'] })}
                />
            )}

            {deletingUser && (
                <DeleteUserDialog
                    user={deletingUser}
                    open={!!deletingUser}
                    onOpenChange={(open) => {
 if (!open) {
setDeletingUser(null);
} 
}}
                />
            )}
        </>
    );
}
