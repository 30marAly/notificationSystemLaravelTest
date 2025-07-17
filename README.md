The project is a notification system that enables the user to enter a single or bulk notifications to be sent at a specific time
It uses a laravel front end that enables the user to create a single notification through a web app or the ability to upload an excel sheet with all the notifications and its necessary information.
A cron job is running every minute that starts a job to check if there are notifications that needs to be sent and if so it starts sending the notifications to rabbit mq.
Meanwhile there is a vertx consumer listening on rabbit mq and once any new notification gets added to the queue it starts a workflow for it that looks at the type of notification and based on the type of notification it starts the correct activity to send it
