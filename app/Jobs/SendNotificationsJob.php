<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SendNotificationsJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;
    public function handle(): void
    {
        $notifications = Notification::where('scheduled_at', '<=', now())
                                     ->where('is_sent', false)
                                     ->get();

        if ($notifications->isEmpty()) {
            echo "⏳ No scheduled notifications to send.\n";
            return;
        }

        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest')
        );

        $channel = $connection->channel();
        $queueName = env('RABBITMQ_QUEUE', 'laravel_queue');
        $channel->queue_declare($queueName, false, true, false, false);

        foreach ($notifications as $notification) {
            $payload = json_encode([
                'title' => $notification->title,
                'description' => $notification->description,
                'notification_type' => $notification->notification_type,
                'recipient' => $notification->recipient,
            ]);

            $msg = new AMQPMessage($payload, ['delivery_mode' => 2]);
            $channel->basic_publish($msg, '', $queueName);
            echo "✅ Sent to RabbitMQ: $payload\n";

            $notification->sent_at = now();
            $notification->is_sent = true;
            $notification->save();
            }

        $channel->close();
        $connection->close();

        echo "🎉 All scheduled notifications sent to RabbitMQ.\n";
    }
}
