<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Models\Notification;

class RemoveNotificationRabbitMq implements ShouldQueue
{
    use Queueable;

    /**
     * The notification ID to remove.
     *
     * @var mixed
     */
    protected $notificationId;

    /**
     * Create a new job instance.
     *
     * @param mixed $notificationId
     */
    public function __construct($notificationId)
    {
        $this->notificationId = $notificationId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest')
        );  

        $channel = $connection->channel();
        $queueName = env('RABBITMQ_QUEUE', 'laravel_queue');
        $channel->queue_declare($queueName, false, true, false, false);

        $autoAck = false;

        $channel->basic_consume( $queueName, '', false, $autoAck, false, false, function (AMQPMessage $message) {
          $notificationData = json_decode($message->body, true);
            Log::info("Received message: " . json_encode($notificationData));
            if ( (int) $notificationData['id'] == (int) $this->notificationId) {
                // Acknowledge the message
                $message->getChannel()->basic_ack($message->getDeliveryTag() , false);
                echo "✅ Notification with ID {$this->notificationId} removed from RabbitMQ.\n";
                Log::info("Job Stopped ");
            } 
            else {
                
                echo "zzzzzzzzzzzzzzz\n";
            }
           
        });

        while ($channel->is_consuming()) {
            $channel->wait();
            Log::info("⏳⏳ channel waited\n") ;
            break; // Exit after processing the message
        }
        
        Log::info("Out from the loop\n") ;
     
        $channel->close();
        $connection->close();
        Log::info("⏳⏳connection & channel closed\n") ;
    }
}


// https://medium.com/@davrv93/integrating-rabbitmq-and-laravel-3-5-creating-a-laravel-consumer-51b5e002af11