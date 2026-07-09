import { Head } from '@inertiajs/react';
import { usePoll } from '@inertiajs/react';
import { useEffect, useRef } from 'react';
import { Badge } from '@/components/ui/badge';

interface Donor {
    id: number;
    full_name: string;
    id_number: string | null;
    email: string;
    tracking_code: string;
}

interface Hospital {
    id: number;
    name: string;
    code: string;
}

interface EventRegistration {
    id: number;
    donor: Donor;
    hospital: Hospital | null;
    queue_number: string;
    status: string;
    created_at: string;
}

interface Event {
    id: number;
    name: string;
    event_date: string;
    venue: string;
    status: string;
}

interface DisplayProps {
    event: Event;
    current: EventRegistration | null;
    next: EventRegistration[];
    waiting: EventRegistration[];
}

function chime() {
    try {
        const ctx = new AudioContext();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.frequency.setValueAtTime(880, ctx.currentTime);
        osc.frequency.setValueAtTime(1100, ctx.currentTime + 0.1);
        gain.gain.setValueAtTime(0.3, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);
        osc.start(ctx.currentTime);
        osc.stop(ctx.currentTime + 0.4);
    } catch {
    }
}

export default function Display({ event, current, next, waiting }: DisplayProps) {
    const prevCurrentId = useRef<number | null>(null);

    usePoll(5000, { only: ['current', 'next', 'waiting'] });

    useEffect(() => {
        if (current && prevCurrentId.current !== null && prevCurrentId.current !== current.id) {
            chime();
        }
        prevCurrentId.current = current?.id ?? null;
    }, [current]);

    const waitingCount = waiting.length;

    return (
        <>
            <Head title={`Display - ${event.name}`} />
            <div className="flex min-h-screen flex-col bg-gradient-to-br from-blue-50 via-white to-blue-50 text-slate-800 overflow-hidden">
                <div className="px-8 pt-6 pb-2">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-2xl font-light tracking-wider text-slate-500">
                                {event.name}
                            </h1>
                            {event.venue && (
                                <p className="text-sm text-slate-400">{event.venue}</p>
                            )}
                        </div>
                        <Badge variant="secondary" className="bg-red-500/10 text-red-600 border-red-500/30">
                            LIVE
                        </Badge>
                    </div>
                </div>

                <div className="flex flex-1 flex-col items-center justify-center px-8 gap-8">
                    <div className="text-center">
                        <p className="text-2xl tracking-[0.3em] uppercase text-slate-400 font-light">
                            Now Serving
                        </p>
                    </div>

                    {current ? (
                        <div className="w-full max-w-4xl rounded-3xl bg-gradient-to-br from-red-600 to-red-700 p-12 shadow-2xl shadow-red-500/20 text-center">
                            <p className="text-[8rem] font-black leading-none tracking-wider text-white drop-shadow-lg">
                                #{current.queue_number?.slice(-3)}
                            </p>
                            <p className="mt-6 text-4xl font-bold text-white/90">
                                {current.donor.full_name}
                            </p>
                            {current.hospital && (
                                <p className="mt-3 text-xl text-white/70">
                                    Assigned: {current.hospital.name}
                                </p>
                            )}
                        </div>
                    ) : (
                        <div className="flex items-center justify-center w-full max-w-4xl rounded-3xl border-2 border-dashed border-slate-300 p-12">
                            <p className="text-3xl text-slate-400 font-light">
                                Waiting for next donor...
                            </p>
                        </div>
                    )}

                    {next.length > 0 && (
                        <div className="w-full max-w-4xl">
                            <p className="mb-4 text-lg text-slate-500 font-light tracking-wide uppercase">
                                Next Up
                            </p>
                            <div className="grid grid-cols-3 gap-4">
                                {next.map((reg) => (
                                    <div
                                        key={reg.id}
                                        className="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm"
                                    >
                                        <p className="text-3xl font-bold text-slate-700">
                                            #{reg.queue_number?.slice(-3)}
                                        </p>
                                        <p className="mt-2 text-lg font-medium text-slate-600">
                                            {reg.donor.full_name}
                                        </p>
                                        {reg.hospital && (
                                            <p className="mt-1 text-sm text-slate-400">
                                                {reg.hospital.name}
                                            </p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                </div>

                <div className="border-t border-slate-200 px-8 py-4">
                    <div className="flex items-center justify-between text-sm text-slate-400">
                        <span>{waitingCount} waiting in queue</span>
                        <span className="animate-pulse text-red-600">● Live</span>
                    </div>
                </div>
            </div>
        </>
    );
}