import { Form } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import login from '@/routes/login';

export default function Login() {
    return (
        <div className="flex min-h-screen items-center justify-center bg-muted/30 p-4">
            <Card className="w-full max-w-md">
                <CardHeader>
                    <CardTitle className="text-center text-2xl">Sign In</CardTitle>
                </CardHeader>
                <CardContent>
                    <Form action={login.authenticate().url} method="post">
                        {({ errors, processing }) => (
                            <div className="space-y-4">
                                <div className="space-y-2">
                                    <Label htmlFor="email">Email</Label>
                                    <Input id="email" type="email" name="email" />
                                    {errors.email && (
                                        <p className="text-sm text-destructive">{errors.email}</p>
                                    )}
                                </div>

                                <div className="space-y-2">
                                    <Label htmlFor="password">Password</Label>
                                    <Input id="password" type="password" name="password" />
                                    {errors.password && (
                                        <p className="text-sm text-destructive">{errors.password}</p>
                                    )}
                                </div>

                                <div className="flex items-center gap-2">
                                    <Checkbox id="remember" name="remember" />
                                    <Label htmlFor="remember" className="text-sm font-normal">Remember me</Label>
                                </div>

                                <Button type="submit" disabled={processing} className="w-full">
                                    {processing ? 'Signing in...' : 'Sign In'}
                                </Button>
                            </div>
                        )}
                    </Form>
                </CardContent>
            </Card>
        </div>
    );
}
