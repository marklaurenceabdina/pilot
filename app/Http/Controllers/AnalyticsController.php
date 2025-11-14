<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    public function index()
    {
        return Inertia::render('EventAnalytics', $this->mockData());
    }

    public function export(): StreamedResponse
    {
        $data = $this->mockData();

        $csv = fopen('php://temp', 'r+');
        // Header row
        fputcsv($csv, ['Section', 'Metric', 'Value']);

        // Attendance
        fputcsv($csv, ['Attendance', 'Registered', $data['attendance']['registered']]);
        fputcsv($csv, ['Attendance', 'Attended', $data['attendance']['attended']]);
        fputcsv($csv, ['Attendance', 'No-shows', $data['attendance']['no_shows']]);

        // Engagement
        fputcsv($csv, ['Engagement', 'Session Duration', $data['engagement']['sessionDuration']]);
        fputcsv($csv, ['Engagement', 'Questions Asked', $data['engagement']['questionsAsked']]);
        fputcsv($csv, ['Engagement', 'Networking Sessions', $data['engagement']['networkingSessions']]);
        fputcsv($csv, ['Engagement', 'Resource Downloads', $data['engagement']['resourceDownloads']]);

        // Feedback
        fputcsv($csv, ['Feedback', 'Overall Rating', $data['feedback']['overallRating']]);
        fputcsv($csv, ['Feedback', 'Would Recommend (%)', $data['feedback']['wouldRecommend']]);
        fputcsv($csv, ['Feedback', 'Responses', $data['feedback']['responses']]);

        rewind($csv);

        return response()->streamDownload(function () use ($csv) {
            fpassthru($csv);
        }, 'event-analytics.csv', ['Content-Type' => 'text/csv']);
    }

    /** Mock data (no DB) */
    private function mockData(): array
    {
        return [
            'attendance' => [
                'registered' => 150,
                'attended'   => 142,
                'no_shows'   => 8,
            ],
            'engagement' => [
                'sessionDuration'   => '2.5 hours avg',
                'questionsAsked'    => 34,
                'networkingSessions'=> 12,
                'resourceDownloads' => 89,
            ],
            'feedback' => [
                'overallRating'  => 4.8,
                'wouldRecommend' => 94,
                'responses'      => 76,
                'recentFeedback' => [
                    [
                        'rating'  => 5,
                        'comment' => 'Great event! The speakers were knowledgeable and the content was very relevant.',
                        'time'    => '2 hours ago',
                    ],
                    [
                        'rating'  => 5,
                        'comment' => 'Good organization and timing. Would love more interactive sessions next time.',
                        'time'    => '3 hours ago',
                    ],
                ],
            ],
        ];
    }
}
