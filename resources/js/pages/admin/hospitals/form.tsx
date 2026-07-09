import { Head, Link, Form } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import admin from '@/routes/admin';

interface Hospital {
    id: number;
    name: string;
    code: string;
}

interface Props {
    hospital?: Hospital | null;
}

export default function HospitalForm({ hospital }: Props) {
    const isEditing = Boolean(hospital);

    return (
        <>
            <Head title={isEditing ? 'Edit Hospital' : 'Create Hospital'} />
            <div className="p-6">
                <h1 className="mb-6 text-2xl font-bold">
                    {isEditing ? 'Edit Hospital' : 'Create Hospital'}
                </h1>

                <div className="mx-auto max-w-lg">
                    <Card>
                        <CardContent className="p-6">
                            <Form
                                {...(isEditing
                                    ? admin.hospitals.update.form(hospital!.id)
                                    : admin.hospitals.store.form())}
                            >
                                {({ errors, processing }) => (
                                    <div className="space-y-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="name">Hospital Name</Label>
                                            <Input id="name" type="text" name="name" defaultValue={hospital?.name ?? ''} />
                                            {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="code">Hospital Code</Label>
                                            <Input id="code" type="text" name="code" defaultValue={hospital?.code ?? ''} />
                                            {errors.code && <p className="text-sm text-destructive">{errors.code}</p>}
                                        </div>

                                        <div className="flex items-center gap-4 pt-4">
                                            <Link href={admin.hospitals.index().url}>
                                                <Button variant="outline" type="button">Cancel</Button>
                                            </Link>
                                            <Button type="submit" disabled={processing}>
                                                {processing ? 'Saving...' : isEditing ? 'Update Hospital' : 'Create Hospital'}
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
