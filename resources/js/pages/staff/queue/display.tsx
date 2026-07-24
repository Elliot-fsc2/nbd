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
            <div className="flex min-h-dvh w-full flex-col bg-gradient-to-br from-blue-950 via-slate-900 to-blue-950 text-white overflow-hidden">
                <div className="flex flex-wrap items-center justify-between gap-x-6 gap-y-2 px-[clamp(1rem,2.5vw,3rem)] py-[clamp(0.5rem,1.5vw,1.5rem)]">
                    <div className="min-w-0">
                        <h1 className="font-bold tracking-wide text-blue-200 text-[clamp(1.25rem,3vw,4rem)] truncate">
                            {event.name}
                        </h1>
                        {event.venue && (
                            <p className="font-semibold text-blue-300/70 text-[clamp(0.875rem,1.8vw,2.5rem)]">{event.venue}</p>
                        )}
                    </div>
                    <div className="flex shrink-0 items-center gap-[clamp(0.75rem,2vw,2rem)]">
                        <span className="font-bold text-blue-200/80 text-[clamp(1rem,2vw,3rem)]">
                            {waitingCount} waiting
                        </span>
                        <span className="animate-pulse font-bold text-red-400 text-[clamp(0.875rem,1.8vw,2.5rem)]">● LIVE</span>
                    </div>
                </div>

                <div className="flex flex-1 flex-col items-stretch gap-[clamp(0.5rem,1.5vw,1.5rem)] px-[clamp(1rem,2.5vw,3rem)] pb-[clamp(0.5rem,1.5vw,1.5rem)]">
                    <div className="flex flex-[4] flex-col items-center justify-center min-h-0">
                        <p className="mb-[clamp(0.5rem,1.5vw,2rem)] tracking-[0.4em] uppercase text-blue-300 font-bold text-[clamp(1rem,3vw,4rem)]">
                            Now Serving
                        </p>

                        {current.length > 0 ? (
                            <div className={`grid w-full gap-[clamp(0.75rem,2vw,2rem)] ${current.length === 1 ? 'grid-cols-1' : current.length === 2 ? 'grid-cols-2' : 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3'}`}>
                                {current.map((reg, i) => (
                                    <div key={reg.id} className="flex flex-col items-center justify-center rounded-2xl md:rounded-3xl bg-gradient-to-br from-red-600 to-red-800 shadow-2xl shadow-red-500/30 text-center px-[clamp(1rem,4vw,3rem)] py-[clamp(1.5rem,4vw,4rem)] min-h-0">
                                        {current.length > 1 && (
                                            <p className="mb-[clamp(0.5rem,1vw,1.5rem)] font-semibold tracking-wider text-white/60 uppercase text-[clamp(0.875rem,2vw,2.5rem)]">
                                                Booth {i + 1}
                                            </p>
                                        )}
                                        <p className="font-black leading-none tracking-wider text-white drop-shadow-2xl text-[clamp(3rem,15vw,12rem)]">
                                            #{reg.queue_number?.slice(-3)}
                                        </p>
                                        <p className="mt-[clamp(0.5rem,1.5vw,1.5rem)] font-bold text-white leading-tight text-[clamp(1rem,4vw,5rem)]">
                                            {reg.donor.full_name}
                                        </p>
                                        {reg.hospital && (
                                            <p className="mt-[clamp(0.25rem,1vw,1rem)] font-bold text-white/70 text-[clamp(0.875rem,2.5vw,3rem)]">
                                                {reg.hospital.name}
                                            </p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="flex items-center justify-center w-full rounded-2xl md:rounded-3xl border-2 border-dashed border-blue-400/40 p-[clamp(2rem,6vw,6rem)]">
                                <p className="font-bold text-blue-300/50 text-center text-[clamp(1.25rem,5vw,6rem)]">
                                    Waiting for next donor...
                                </p>
                            </div>
                        )}
                    </div>

                    {next.length > 0 && (
                        <div className="rounded-2xl md:rounded-3xl border border-blue-400/20 bg-blue-900/30 px-[clamp(1rem,2.5vw,2rem)] py-[clamp(0.75rem,1.5vw,1.25rem)]">
                            <p className="mb-[clamp(0.5rem,1vw,1rem)] text-center font-bold tracking-wider uppercase text-blue-300 text-[clamp(0.875rem,2vw,2.5rem)]">
                                Next Up
                            </p>
                            <div className="flex flex-row flex-wrap gap-[clamp(0.5rem,1vw,1rem)] justify-center">
                                {next.map((reg) => (
                                    <div
                                        key={reg.id}
                                        className="flex-1 rounded-xl md:rounded-2xl border border-blue-400/20 bg-blue-800/40 px-[clamp(0.75rem,2vw,1.5rem)] py-[clamp(0.5rem,1.5vw,1.25rem)] text-center min-w-[150px] max-w-full"
                                    >
                                        <p className="font-black text-white text-[clamp(1.25rem,4vw,3.5rem)]">
                                            #{reg.queue_number?.slice(-3)}
                                        </p>
                                        <p className="mt-1 font-bold text-white text-[clamp(0.75rem,2.5vw,2.25rem)]">
                                            {reg.donor.full_name}
                                        </p>
                                        {reg.hospital && (
                                            <p className="font-semibold text-blue-200/70 text-[clamp(0.625rem,1.8vw,1.75rem)]">
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
