<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DonationExportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $donations = Donation::query()
            ->with('fundraiser')
            ->orderByDesc('donated_at')
            ->get();

        $filename = 'donations_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(
            function () use ($donations): void {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['ID', 'Сбор', 'Сумма', 'Имя', 'Email', 'Анонимно', 'Дата'], ';');
                foreach ($donations as $d) {
                    fputcsv($out, [
                        $d->id,
                        $d->fundraiser?->title ?? '',
                        $d->amount,
                        $d->is_anonymous ? '' : ($d->donor_name ?? ''),
                        $d->is_anonymous ? '' : ($d->donor_email ?? ''),
                        $d->is_anonymous ? 'Да' : 'Нет',
                        $d->donated_at?->format('d.m.Y H:i'),
                    ], ';');
                }
                fclose($out);
            },
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]
        );
    }
}
