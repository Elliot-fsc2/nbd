import { format } from 'date-fns';
import { CalendarIcon } from 'lucide-react';
import * as React from 'react';
import type { DateRange } from 'react-day-picker';

import { cn } from '@/lib/utils';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';

interface DateRangePickerProps {
    value: DateRange | undefined;
    onChange: (range: DateRange | undefined) => void;
    className?: string;
}

export function DateRangePicker({
    value,
    onChange,
    className,
}: DateRangePickerProps) {
    const [open, setOpen] = React.useState(false);

    function handleSelect(range: DateRange | undefined) {
        onChange(range);
        // Auto-close when both dates are selected (completed range)
        if (range?.from && range?.to) {
            setOpen(false);
        }
    }

    return (
        <Popover open={open} onOpenChange={setOpen}>
            <PopoverTrigger asChild>
                <Button
                    variant="outline"
                    className={cn(
                        'w-[260px] justify-start text-left font-normal',
                        !value && 'text-muted-foreground',
                        className,
                    )}
                >
                    <CalendarIcon className="mr-2 size-4" />
                    {value?.from ? (
                        value.to ? (
                            `${format(value.from, 'MMM d, yyyy')} — ${format(value.to, 'MMM d, yyyy')}`
                        ) : (
                            format(value.from, 'MMM d, yyyy')
                        )
                    ) : (
                        <span>Pick a date range</span>
                    )}
                </Button>
            </PopoverTrigger>
            <PopoverContent className="w-auto p-0" align="start">
                <Calendar
                    mode="range"
                    selected={value}
                    onSelect={handleSelect}
                    numberOfMonths={2}
                />
            </PopoverContent>
        </Popover>
    );
}
