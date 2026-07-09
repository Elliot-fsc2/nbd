import type { PageProps } from '@inertiajs/core';
import { useForm, router } from '@inertiajs/react';
import { useState } from 'react';
import { z } from 'zod';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { register } from '@/routes';

interface Course {
    id: number;
    name: string;
    department: { id: number; name: string } | null;
}

interface Hospital {
    id: number;
    name: string;
    code: string;
}

interface HouseOfHeroesOption {
    value: string;
    label: string;
}

interface WelcomeProps extends PageProps {
    hospitals: Hospital[];
    courses: Course[];
    houseOfHeroes: HouseOfHeroesOption[];
}

type FormData = {
    surname: string;
    given_name: string;
    middle_name: string;
    birthdate: string;
    age: string;
    sex: string;
    civil_status: string;
    blood_type: string;
    occupation: string;
    house_heroes: string;
    course_id: string;
    year_section: string;
    house_no: string;
    street: string;
    subdivision: string;
    barangay: string;
    city_province: string;
    email: string;
    contact_number: string;
    donor_type: string;
    id_number: string;
    representative_full_name: string;
    consent: string;
};

const initialData: FormData = {
    surname: '',
    given_name: '',
    middle_name: '',
    birthdate: '',
    age: '',
    sex: '',
    civil_status: '',
    blood_type: '',
    occupation: '',
    house_heroes: '',
    course_id: '',
    year_section: '',
    house_no: '',
    street: '',
    subdivision: '',
    barangay: '',
    city_province: '',
    email: '',
    contact_number: '',
    donor_type: '',
    id_number: '',
    representative_full_name: '',
    consent: '',
};

function computeAge(birthdate: string): string {
    if (!birthdate) {
return '';
}

    const bd = new Date(birthdate);
    const today = new Date();
    let age = today.getFullYear() - bd.getFullYear();
    const m = today.getMonth() - bd.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) {
age--;
}

    return String(age);
}

export default function Welcome({ courses, houseOfHeroes }: WelcomeProps) {
    const [step, setStep] = useState(1);
    const [isRepresentative, setIsRepresentative] = useState(false);
    const [submitted, setSubmitted] = useState(false);

    const { data, setData, post, errors, processing } = useForm<FormData>(initialData);

    function updateBirthdate(value: string) {
        setData({
            ...data,
            birthdate: value,
            age: computeAge(value),
        });
    }

    const [zodErrors, setZodErrors] = useState<Record<string, string>>({});

    function setField(field: keyof FormData, value: string) {
        setData(field, value);
        setZodErrors((prev) => {
            if (!prev[field]) {
return prev;
}

            const next = { ...prev };
            delete next[field];

            return next;
        });
    }

    const nameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿŃñ\s.\-']+$/;
    const textRegex = /^[A-Za-zÀ-ÖØ-öø-ÿŃñ0-9\s.,\-']+$/;

    const step1Schema = z.object({
        surname: z.string().min(1, 'Surname is required').regex(nameRegex, 'Surname should only contain letters'),
        given_name: z.string().min(1, 'Given name is required').regex(nameRegex, 'Given name should only contain letters'),
        birthdate: z.string().min(1, 'Date of birth is required'),
        sex: z.string().min(1, 'Sex is required'),
        civil_status: z.string().min(1, 'Civil status is required'),
        blood_type: z.string().min(1, 'Blood type is required'),
        occupation: z.string().min(1, 'Occupation is required').regex(textRegex, 'Occupation contains invalid characters'),
        barangay: z.string().min(1, 'Barangay is required').regex(nameRegex, 'Barangay should only contain letters'),
        city_province: z.string().min(1, 'City/province is required').regex(nameRegex, 'City/province should only contain letters'),
        email: z.string().min(1, 'Email is required').email('Invalid email format'),
        contact_number: z.string().min(1, 'Contact number is required').regex(/^(09|\+639)\d{9}$/, 'Enter a valid PH mobile number (e.g. 09XX XXX XXXX)'),
        house_heroes: z.string().optional(),
        course_id: z.string().optional(),
        representative_full_name: z.string().optional().refine(
            (val) => !val || nameRegex.test(val),
            'Full name should only contain letters',
        ),
        id_number: z.string().optional(),
        year_section: z.string().optional(),
    }).superRefine((val, ctx) => {
        if (!isRepresentative && !val.id_number) {
            ctx.addIssue({ code: 'custom', path: ['id_number'], message: 'Student/Employee ID is required' });
        }
        if (!isRepresentative && !val.house_heroes) {
            ctx.addIssue({ code: 'custom', path: ['house_heroes'], message: 'House of Heroes is required' });
        }
    });

    function handleNext() {
        const fields: Record<string, string> = {
            surname: data.surname,
            given_name: data.given_name,
            birthdate: data.birthdate,
            sex: data.sex,
            civil_status: data.civil_status,
            blood_type: data.blood_type,
            occupation: data.occupation,
            barangay: data.barangay,
            city_province: data.city_province,
            email: data.email,
            contact_number: data.contact_number,
        };

        if (isRepresentative) {
            fields.representative_full_name = data.representative_full_name;
            fields.id_number = data.id_number;
        } else {
            fields.id_number = data.id_number;
            fields.house_heroes = data.house_heroes;
            fields.course_id = data.course_id;
        }

        const result = step1Schema.safeParse(fields);

        if (!result.success) {
            const fieldErrors: Record<string, string> = {};

            for (const issue of result.error.issues) {
                fieldErrors[issue.path[0] as string] = issue.message;
            }

            setZodErrors(fieldErrors);

            return;
        }

        setZodErrors({});
        setStep(2);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function handleBack() {
        setStep(1);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function handleSubmit() {
        if (!data.consent) {
            return;
        }

        post(register.url(), {
            onSuccess: () => setSubmitted(true),
            onError: () => setStep(1),
        });
    }

    if (submitted) {
        return (
            <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-red-50 to-white p-4">
                <div className="w-full max-w-lg text-center">
                    <div className="mx-auto mb-6 flex size-16 items-center justify-center rounded-full bg-green-100">
                        <svg className="size-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 className="mb-2 text-xl font-bold text-gray-800">Form Submitted Successfully!</h2>
                    <p className="mb-1 text-sm text-gray-600">Thank you for registering as a blood donor.</p>
                    <p className="mb-6 text-sm text-gray-600">
                        Please <strong>check your email</strong> &mdash; your completed donor form has been sent to your inbox.
                    </p>
                    <Button onClick={() => window.location.reload()}>
                        Submit Another Response
                    </Button>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gradient-to-br from-red-50 to-white py-8">
            <div className="mx-auto max-w-2xl px-4">
                <div className="mb-8 text-center">
                    <h1 className="text-3xl font-bold text-gray-800">Blood Donation Registration</h1>
                    <p className="mt-1 text-sm text-gray-500">Fill out the form below to register as a blood donor.</p>
                </div>

                {/* Step Tracker */}
                <div className="relative mb-8 mx-auto max-w-sm">
                    <div className="absolute top-5 left-0 right-0 h-0.5 bg-red-100 z-0 mx-6" />
                    <div
                        className="absolute top-5 left-0 h-0.5 bg-red-500 z-0 mx-6 transition-all duration-500"
                        style={{ width: `calc(${(step - 1)} * (100% - 3rem))` }}
                    />
                    <div className="flex items-center justify-between relative">
                        {[{ label: 'Personal', icon: '👤' }, { label: 'Confirm', icon: '✓' }].map((s, i) => {
                            const n = i + 1;

                            return (
                                <div key={n} className="flex flex-col items-center z-10 gap-1.5 px-2">
                                    <div
                                        className={`flex items-center justify-center size-10 rounded-full text-sm font-bold border-2 transition-all duration-300 ${
                                            step === n
                                                ? 'bg-red-600 border-red-600 text-white shadow-md shadow-red-200'
                                                : step > n
                                                  ? 'bg-red-500 border-red-500 text-white'
                                                  : 'bg-white border-red-200 text-red-300'
                                        }`}
                                    >
                                        {step > n ? (
                                            <svg className="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                                            </svg>
                                        ) : (
                                            s.icon
                                        )}
                                    </div>
                                    <span className={`text-[0.65rem] font-medium hidden sm:block transition-colors duration-300 ${
                                        step >= n ? 'text-red-600' : 'text-gray-400'
                                    }`}>
                                        {s.label}
                                    </span>
                                </div>
                            );
                        })}
                    </div>
                </div>

                <div className="rounded-xl border bg-white shadow-sm">
                    {/* Step 1: Personal Data */}
                    {step === 1 && (
                        <div className="p-6">
                            <div className="flex items-center gap-3 mb-6 pb-4 border-b border-red-100">
                                <div className="flex size-9 items-center justify-center rounded-full bg-red-50 text-red-600 shrink-0">
                                    <svg className="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className="font-semibold text-base">Personal Data</h3>
                                    <p className="text-xs text-gray-500">Fields marked <span className="text-red-500">*</span> are required.</p>
                                </div>
                            </div>

                            {/* Representative Toggle */}
                            <div className="mb-5 rounded-xl border border-amber-200 bg-amber-50/40 p-4">
                                <label className="flex items-start gap-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={isRepresentative}
                                        onChange={(e) => {
                                            const checked = e.target.checked;
                                            setIsRepresentative(checked);
                                            setData({
                                                ...data,
                                                donor_type: checked ? 'representative' : '',
                                                id_number: '',
                                                representative_full_name: '',
                                                house_heroes: '',
                                                course_id: '',
                                                year_section: '',
                                            });
                                        }}
                                        className="mt-1 size-4 rounded border-gray-300 text-red-600 focus:ring-red-500"
                                    />
                                    <span className="text-sm font-medium text-gray-700">I am donating as a Representative</span>
                                </label>
                            </div>

                            {/* Representative Fields */}
                            {isRepresentative && (
                                <div className="rounded-xl border border-amber-200 bg-amber-50/40 p-4 space-y-4">
                                    <p className="text-xs font-semibold text-amber-700 uppercase tracking-wider">Representative For:</p>
                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="id_number">Student/Employee ID</Label>
                                            <Input id="id_number" value={data.id_number} onChange={(e) => setData('id_number', e.target.value)} placeholder="e.g. 2024-00123" />
                                            {(zodErrors.id_number || errors.id_number) && <p className="text-xs text-destructive">{zodErrors.id_number || errors.id_number}</p>}
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="representative_full_name">Full Name</Label>
                                            <Input id="representative_full_name" value={data.representative_full_name} onChange={(e) => setData('representative_full_name', e.target.value)} placeholder="e.g. Juan Dela Cruz" />
                                            {(zodErrors.representative_full_name || errors.representative_full_name) && <p className="text-xs text-destructive">{zodErrors.representative_full_name || errors.representative_full_name}</p>}
                                        </div>
                                    </div>
                                </div>
                            )}

                            <div className="space-y-5">
                                {/* Name */}
                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="surname">Surname <span className="text-red-500">*</span></Label>
                                        <Input id="surname" value={data.surname} onChange={(e) => setData('surname', e.target.value)} placeholder="e.g. Dela Cruz" />
                                        {(zodErrors.surname || errors.surname) && <p className="text-xs text-destructive">{zodErrors.surname || errors.surname}</p>}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="given_name">Given Name <span className="text-red-500">*</span></Label>
                                        <Input id="given_name" value={data.given_name} onChange={(e) => setData('given_name', e.target.value)} placeholder="e.g. Juan" />
                                        {(zodErrors.given_name || errors.given_name) && <p className="text-xs text-destructive">{zodErrors.given_name || errors.given_name}</p>}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="middle_name">Middle Name</Label>
                                        <Input id="middle_name" value={data.middle_name} onChange={(e) => setData('middle_name', e.target.value)} placeholder="e.g. Santos" />
                                    </div>
                                </div>

                                {/* Personal Details */}
                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="birthdate">Date of Birth <span className="text-red-500">*</span></Label>
                                        <Input id="birthdate" type="date" value={data.birthdate} onChange={(e) => updateBirthdate(e.target.value)} />
                                        {(zodErrors.birthdate || errors.birthdate) && <p className="text-xs text-destructive">{zodErrors.birthdate || errors.birthdate}</p>}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="sex">Sex <span className="text-red-500">*</span></Label>
                                        <Select value={data.sex} onValueChange={(v) => setData('sex', v)}>
                                            <SelectTrigger id="sex"><SelectValue placeholder="Select..." /></SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="male">Male</SelectItem>
                                                <SelectItem value="female">Female</SelectItem>
                                            </SelectContent>
                                        </Select>
                                        {(zodErrors.sex || errors.sex) && <p className="text-xs text-destructive">{zodErrors.sex || errors.sex}</p>}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="civil_status">Civil Status <span className="text-red-500">*</span></Label>
                                        <Select value={data.civil_status} onValueChange={(v) => setData('civil_status', v)}>
                                            <SelectTrigger id="civil_status"><SelectValue placeholder="Select..." /></SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="single">Single</SelectItem>
                                                <SelectItem value="married">Married</SelectItem>
                                                <SelectItem value="divorced">Separated</SelectItem>
                                                <SelectItem value="widowed">Widowed</SelectItem>
                                            </SelectContent>
                                        </Select>
                                        {(zodErrors.civil_status || errors.civil_status) && <p className="text-xs text-destructive">{zodErrors.civil_status || errors.civil_status}</p>}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="blood_type">Blood Type <span className="text-red-500">*</span></Label>
                                        <Select value={data.blood_type} onValueChange={(v) => setData('blood_type', v)}>
                                            <SelectTrigger id="blood_type"><SelectValue placeholder="Select..." /></SelectTrigger>
                                            <SelectContent>
                                                {['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Unknown'].map((bt) => (
                                                    <SelectItem key={bt} value={bt}>{bt}</SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {(zodErrors.blood_type || errors.blood_type) && <p className="text-xs text-destructive">{zodErrors.blood_type || errors.blood_type}</p>}
                                    </div>
                                </div>

                                {/* Occupation & House of Heroes */}
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="occupation">Occupation <span className="text-red-500">*</span></Label>
                                        <Input id="occupation" value={data.occupation} onChange={(e) => setData('occupation', e.target.value)} placeholder="e.g. Student, Engineer..." />
                                        {(zodErrors.occupation || errors.occupation) && <p className="text-xs text-destructive">{zodErrors.occupation || errors.occupation}</p>}
                                    </div>
                                    {!isRepresentative && (
                                        <div className="space-y-2">
                                            <Label htmlFor="house_heroes">House of Heroes <span className="text-red-500">*</span></Label>
                                            <Select value={data.house_heroes} onValueChange={(v) => setData('house_heroes', v)}>
                                                <SelectTrigger id="house_heroes"><SelectValue placeholder="Select..." /></SelectTrigger>
                                                <SelectContent>
                                                    {houseOfHeroes.map((h) => (
                                                        <SelectItem key={h.value} value={h.value}>{h.label}</SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                            {(zodErrors.house_heroes || errors.house_heroes) && <p className="text-xs text-destructive">{zodErrors.house_heroes || errors.house_heroes}</p>}
                                        </div>
                                    )}
                                </div>

                                {/* Student/Employee ID (for non-representatives) */}
                                {!isRepresentative && (
                                    <div className="space-y-2">
                                        <Label htmlFor="id_number">Student/Employee ID <span className="text-red-500">*</span></Label>
                                        <Input id="id_number" value={data.id_number} onChange={(e) => setData('id_number', e.target.value)} placeholder="e.g. 2024-00123" />
                                        {(zodErrors.id_number || errors.id_number) && <p className="text-xs text-destructive">{zodErrors.id_number || errors.id_number}</p>}
                                    </div>
                                )}

                                {/* Course */}
                                {!isRepresentative && (
                                    <div className="space-y-2">
                                        <Label htmlFor="course_id">Course <span className="text-red-500">*</span></Label>
                                        <Select value={data.course_id} onValueChange={(v) => setData('course_id', v)}>
                                            <SelectTrigger id="course_id"><SelectValue placeholder="Select course..." /></SelectTrigger>
                                            <SelectContent>
                                                {courses.map((c) => (
                                                    <SelectItem key={c.id} value={String(c.id)}>
                                                        {c.name} ({c.department?.name ?? 'No Department'})
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {(zodErrors.course_id || errors.course_id) && <p className="text-xs text-destructive">{zodErrors.course_id || errors.course_id}</p>}
                                    </div>
                                )}

                                {/* Address */}
                                <div>
                                    <p className="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Address</p>
                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="house_no">House No / Street</Label>
                                            <Input id="house_no" value={data.house_no} onChange={(e) => setData('house_no', e.target.value)} placeholder="123 Rizal St." />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="street">Street / Subdivision</Label>
                                            <Input id="street" value={data.street} onChange={(e) => setData('street', e.target.value)} placeholder="Subdivision / Village" />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="barangay">Barangay <span className="text-red-500">*</span></Label>
                                            <Input id="barangay" value={data.barangay} onChange={(e) => setData('barangay', e.target.value)} />
                                            {(zodErrors.barangay || errors.barangay) && <p className="text-xs text-destructive">{zodErrors.barangay || errors.barangay}</p>}
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="city_province">City / Province <span className="text-red-500">*</span></Label>
                                            <Input id="city_province" value={data.city_province} onChange={(e) => setData('city_province', e.target.value)} />
                                            {(zodErrors.city_province || errors.city_province) && <p className="text-xs text-destructive">{zodErrors.city_province || errors.city_province}</p>}
                                        </div>
                                    </div>
                                </div>

                                {/* Contact */}
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="email">Email Address <span className="text-red-500">*</span></Label>
                                        <Input id="email" type="email" value={data.email} onChange={(e) => setData('email', e.target.value)} placeholder="you@example.com" />
                                        {(zodErrors.email || errors.email) && <p className="text-xs text-destructive">{zodErrors.email || errors.email}</p>}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="contact_number">Contact Number <span className="text-red-500">*</span></Label>
                                        <Input id="contact_number" value={data.contact_number} onChange={(e) => setData('contact_number', e.target.value)} placeholder="09XX XXX XXXX" />
                                        {(zodErrors.contact_number || errors.contact_number) && <p className="text-xs text-destructive">{zodErrors.contact_number || errors.contact_number}</p>}
                                    </div>
                                </div>
                            </div>

                            {/* Navigation */}
                            <div className="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-gray-100">
                                <span className="text-xs text-gray-400 hidden sm:block">Step 1 of 2</span>
                                <Button onClick={handleNext} className="bg-black hover:bg-gray-900 text-white">
                                    Next
                                    <svg className="size-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </Button>
                            </div>
                        </div>
                    )}

                    {/* Step 2: Review & Confirm */}
                    {step === 2 && (
                        <div className="p-6">
                            <div className="flex items-center gap-3 mb-6 pb-4 border-b border-red-100">
                                <div className="flex size-9 items-center justify-center rounded-full bg-red-50 text-red-600 shrink-0">
                                    <svg className="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className="font-semibold text-base">Review & Confirm</h3>
                                    <p className="text-xs text-gray-500">Please review all your answers carefully before submitting.</p>
                                </div>
                            </div>

                            <div className="space-y-5 text-sm">
                                {/* Personal Data Review */}
                                <div className="rounded-xl border border-gray-200 overflow-hidden">
                                    <div className="flex items-center gap-2 bg-red-50 px-4 py-2.5 border-b border-red-100">
                                        <span>👤</span>
                                        <p className="text-xs font-bold text-red-700 uppercase tracking-wider">Personal Data</p>
                                    </div>
                                    <div className="grid grid-cols-2 sm:grid-cols-3 gap-px bg-gray-100">
                                        {[
                                            ['Surname', data.surname],
                                            ['Given Name', data.given_name],
                                            ['Middle Name', data.middle_name || '—'],
                                            ['Date of Birth', data.birthdate],
                                            ['Blood Type', data.blood_type],
                                            ['Sex', data.sex === 'male' ? 'Male' : 'Female'],
                                            ['Civil Status', data.civil_status.charAt(0).toUpperCase() + data.civil_status.slice(1)],
                                            ['Occupation', data.occupation],
                                            ...(isRepresentative ? [] : [
                                                ['Student/Employee ID', data.id_number || '—'],
                                                ['House of Heroes', houseOfHeroes.find((h) => h.value === data.house_heroes)?.label || '—'],
                                            ] as [string, string][]),
                                            ['House No/Street', data.house_no || (data.street || '—')],
                                            ['Barangay', data.barangay],
                                            ['City/Province', data.city_province],
                                            ['Email', data.email],
                                            ['Contact No.', data.contact_number],
                                        ].map(([label, val]) => (
                                            <div key={label} className="bg-white px-3 py-2">
                                                <p className="text-[0.65rem] text-gray-400 uppercase tracking-wide mb-0.5">{label}</p>
                                                <p className="font-medium text-gray-800">{val}</p>
                                            </div>
                                        ))}
                                    </div>
                                </div>

                                {/* Representative */}
                                {isRepresentative && (
                                    <div className="rounded-xl border border-amber-200 overflow-hidden">
                                        <div className="flex items-center gap-2 bg-amber-50 px-4 py-2.5 border-b border-amber-100">
                                            <span>🔁</span>
                                            <p className="text-xs font-bold text-amber-700 uppercase tracking-wider">Donating as Representative For</p>
                                        </div>
                                        <div className="grid grid-cols-2 gap-px bg-gray-100">
                                            {[
                                                ['Student/Employee ID', data.id_number],
                                                ['Full Name', data.representative_full_name],
                                            ].map(([label, val]) => (
                                                <div key={label} className="bg-white px-3 py-2">
                                                    <p className="text-[0.65rem] text-gray-400 uppercase tracking-wide mb-0.5">{label}</p>
                                                    <p className="font-medium text-gray-800">{val || '—'}</p>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                )}
                            </div>

                            {/* Consent */}
                            <div className="mt-5 rounded-xl border border-red-200 bg-red-50/40 p-4">
                                <div className="flex gap-3 mb-4">
                                    <svg className="size-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p className="text-xs text-gray-600 italic leading-relaxed">
                                        "I voluntarily give my consent for the collection, use, and processing of my personal data for the blood donation event. I declare that I have truthfully answered all of the above questions."
                                    </p>
                                </div>
                                <label className="flex items-start gap-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={data.consent === '1'}
                                        onChange={(e) => setData('consent', e.target.checked ? '1' : '')}
                                        className="mt-1 size-4 rounded border-gray-300 text-red-600 focus:ring-red-500"
                                    />
                                    <span className="text-sm text-gray-700">I have read and understand the consent terms.</span>
                                </label>
                                {errors.consent && <p className="text-xs text-destructive mt-1">{errors.consent}</p>}
                            </div>

                            {/* Navigation */}
                            <div className="flex items-center justify-between gap-3 mt-8 pt-5 border-t border-gray-100">
                                <Button onClick={handleBack} variant="ghost">
                                    <svg className="size-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Back
                                </Button>
                                <div className="flex items-center gap-3">
                                    <span className="text-xs text-gray-400 hidden sm:block">Step 2 of 2</span>
                                    <Button
                                        onClick={handleSubmit}
                                        disabled={processing || !data.consent}
                                        className="bg-black hover:bg-gray-900 text-white"
                                    >
                                        {processing ? 'Submitting...' : 'Submit'}
                                        <svg className="size-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                        </svg>
                                    </Button>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
