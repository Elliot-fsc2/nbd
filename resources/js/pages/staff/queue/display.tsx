import { Head } from '@inertiajs/react';
import { usePoll } from '@inertiajs/react';
import { useEffect, useRef } from 'react';

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
    current: EventRegistration[];
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
    const prevIds = useRef<string>('');

    usePoll(5000, { only: ['current', 'next', 'waiting'] });

    useEffect(() => {
        const ids = current.map((r) => r.id).sort().join(',');
        if (prevIds.current !== '' && prevIds.current !== ids) {
            chime();
        }
        prevIds.current = ids;
    }, [current]);

    const waitingCount = waiting.length;

    return (
        <>
            <Head title={`Display - ${event.name}`} />
            <div className="flex h-screen flex-col bg-gradient-to-br from-blue-950 via-slate-900 to-blue-950 text-white overflow-hidden">
                <div className="flex items-center justify-between px-10 py-3">
                    <div>
                        <h1 className="text-3xl font-bold tracking-wide text-blue-200">
                            {event.name}
                        </h1>
                        {event.venue && (
                            <p className="text-xl font-semibold text-blue-300/70">{event.venue}</p>
                        )}
                    </div>
                    <div className="flex items-center gap-4">
                        <span className="text-2xl font-bold text-blue-200/80">
                            {waitingCount} waiting
                        </span>
                        <span className="animate-pulse text-xl font-bold text-red-400">● LIVE</span>
                    </div>
                </div>

                <div className="flex flex-1 items-stretch gap-4 px-10 pb-4">
                    <div className="flex flex-[3] flex-col items-center justify-center">
                        <p className="mb-6 text-3xl tracking-[0.4em] uppercase text-blue-300 font-bold">
                            Now Serving
                        </p>

                        {current.length > 0 ? (
                            <div className={`grid w-full gap-6 ${current.length === 1 ? 'grid-cols-1' : current.length === 2 ? 'grid-cols-2' : 'grid-cols-3'}`}>
                                {current.map((reg, i) => (
                                    <div key={reg.id} className="flex flex-col items-center justify-center rounded-3xl bg-gradient-to-br from-red-600 to-red-800 px-8 py-10 shadow-2xl shadow-red-500/30 text-center min-h-0">
                                        {current.length > 1 && (
                                            <p className="mb-2 text-2xl font-semibold tracking-wider text-white/60 uppercase">
                                                Booth {i + 1}
                                            </p>
                                        )}
                                        <p className="font-black leading-none tracking-wider text-white drop-shadow-2xl text-[10rem]">
                                            #{reg.queue_number?.slice(-3)}
                                        </p>
                                        <p className="mt-4 font-bold text-white text-5xl leading-tight">
                                            {reg.donor.full_name}
                                        </p>
                                        {reg.hospital && (
                                            <p className="mt-3 text-3xl font-bold text-white/70">
                                                {reg.hospital.name}
                                            </p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="flex items-center justify-center w-full rounded-3xl border-2 border-dashed border-blue-400/40 p-12">
                                <p className="text-6xl font-bold text-blue-300/50">
                                    Waiting for next donor...
                                </p>
                            </div>
                        )}
                    </div>

                    {next.length > 0 && (
                        <div className="flex flex-1 flex-col justify-center rounded-3xl border border-blue-400/20 bg-blue-900/30 px-6 py-6">
                            <p className="mb-4 text-center text-2xl font-bold tracking-wider uppercase text-blue-300">
                                Next Up
                            </p>
                            <div className="flex flex-col gap-3">
                                {next.map((reg) => (
                                    <div
                                        key={reg.id}
                                        className="rounded-2xl border border-blue-400/20 bg-blue-800/40 px-5 py-4 text-center"
                                    >
                                        <p className="text-5xl font-black text-white">
                                            #{reg.queue_number?.slice(-3)}
                                        </p>
                                        <p className="mt-1 text-2xl font-bold text-white">
                                            {reg.donor.full_name}
                                        </p>
                                        {reg.hospital && (
                                            <p className="text-xl font-semibold text-blue-200/70">
                                                {reg.hospital.name}
                                            </p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
