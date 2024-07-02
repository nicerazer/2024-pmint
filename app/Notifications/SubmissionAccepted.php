<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\WorkLog;

class SubmissionAccepted extends Notification
{
    use Queueable;

    private WorkLog $worklog;
    private User $author;
    private User $evaluator;

    /**
     * Create a new notification instance.
     */
    public function __construct(WorkLog $wl, User $author, User $evaluator)
    {
        $this->worklog = $wl;
        $this->author = $author;
        $this->evaluator = $evaluator;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'author_id' => $this->author->id,
            'evaluator_id' => $this->evaluator->id,
            'evaluator_name' => $this->evaluator->name,
            'evaluated_at' => $this->worklog->latestSubmission->evaluated_at,
            'worklog_id' => $this->worklog->id,
        ];
    }
}
