import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

interface PdfPreviewDialogProps {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    title: string;
    previewUrl: string;
    downloadUrl: string;
}

export default function PdfPreviewDialog({
    open,
    onOpenChange,
    title,
    previewUrl,
    downloadUrl,
}: PdfPreviewDialogProps) {
    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="max-w-4xl max-h-[90vh] p-0 overflow-hidden">
                <DialogHeader className="p-6 pb-3">
                    <DialogTitle>{title}</DialogTitle>
                </DialogHeader>

                <iframe
                    src={previewUrl}
                    title={`${title} preview`}
                    className="h-[65vh] w-full border-y border-gray-200"
                />

                <div className="flex justify-end p-4">
                    <a href={downloadUrl} target="_blank" rel="noopener noreferrer">
                        <Button variant="default">Download PDF</Button>
                    </a>
                </div>
            </DialogContent>
        </Dialog>
    );
}
