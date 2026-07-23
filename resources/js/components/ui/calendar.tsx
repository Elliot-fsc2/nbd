import { ChevronLeft, ChevronRight } from 'lucide-react';
import * as React from 'react';
import { DayPicker } from 'react-day-picker';

import { cn } from '@/lib/utils';
import { buttonVariants } from '@/components/ui/button';

export type CalendarProps = React.ComponentProps<typeof DayPicker>;

function Calendar({
    className,
    classNames,
    showOutsideDays = true,
    ...props
}: CalendarProps) {
    return (
        <DayPicker
            showOutsideDays={showOutsideDays}
            className={cn('p-3', className)}
            classNames={{
                months: 'flex flex-col sm:flex-row gap-2',
                month: 'flex flex-col gap-4',
                month_caption: 'flex justify-center pt-1 relative items-center w-full',
                caption_label: 'text-sm font-medium',
                nav: 'flex items-center gap-1',
                button_previous: cn(
                    buttonVariants({ variant: 'outline' }),
                    'absolute left-1 size-7 bg-transparent p-0 opacity-50 hover:opacity-100',
                ),
                button_next: cn(
                    buttonVariants({ variant: 'outline' }),
                    'absolute right-1 size-7 bg-transparent p-0 opacity-50 hover:opacity-100',
                ),
                month_grid: 'w-full border-collapse space-x-1',
                weekdays: 'flex',
                weekday: 'text-muted-foreground rounded-md w-8 font-normal text-[0.8rem]',
                week: 'flex w-full mt-2',
                day: cn(
                    buttonVariants({ variant: 'ghost' }),
                    'relative p-0 text-center text-sm size-8 font-normal focus-within:relative focus-within:z-20 [&:has([aria-selected])]:bg-accent aria-selected:opacity-100 data-[selected]:bg-primary data-[selected]:text-primary-foreground data-[selected]:hover:bg-primary data-[selected]:hover:text-primary-foreground data-[selected]:focus:bg-primary data-[selected]:focus:text-primary-foreground data-[range-start]:rounded-l-md data-[range-end]:rounded-r-md data-[range-middle]:bg-accent data-[range-middle]:text-accent-foreground data-[today]:bg-accent data-[today]:text-accent-foreground data-[outside]:text-muted-foreground',
                ),
                day_button: cn(
                    buttonVariants({ variant: 'ghost' }),
                    'size-8 p-0 font-normal aria-selected:opacity-100 data-[selected]:bg-primary data-[selected]:text-primary-foreground data-[selected]:hover:bg-primary data-[selected]:hover:text-primary-foreground',
                ),
                ...classNames,
            }}
            components={{
                Chevron: ({ orientation }) =>
                    orientation === 'left' ? (
                        <ChevronLeft className="size-4" />
                    ) : (
                        <ChevronRight className="size-4" />
                    ),
            }}
            {...props}
        />
    );
}

export { Calendar };
