import { Head, Link, Form } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import admin from '@/routes/admin';

interface Department {
    id: number;
    name: string;
}

interface Props {
    department?: Department | null;
}

export default function DepartmentForm({ department }: Props) {
    const isEditing = Boolean(department);

    return (
        <>
            <Head title={isEditing ? 'Edit Department' : 'Create Department'} />
            <div className="p-6">
                <h1 className="mb-6 text-2xl font-bold">
                    {isEditing ? 'Edit Department' : 'Create Department'}
                </h1>

                <div className="mx-auto max-w-lg">
                    <Card>
                        <CardContent className="p-6">
                            <Form
                                {...(isEditing
                                    ? admin.departments.update.form(department!.id)
                                    : admin.departments.store.form())}
                            >
                                {({ errors, processing }) => (
                                    <div className="space-y-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="name">Department Name</Label>
                                            <Input id="name" type="text" name="name" defaultValue={department?.name ?? ''} />
                                            {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
                                        </div>

                                        <div className="flex items-center gap-4 pt-4">
                                            <Link href={admin.departments.index().url}>
                                                <Button variant="outline" type="button">Cancel</Button>
                                            </Link>
                                            <Button type="submit" disabled={processing}>
                                                {processing ? 'Saving...' : isEditing ? 'Update Department' : 'Create Department'}
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
