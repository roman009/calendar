# calendar API

## google
- https://developers.google.com/calendar/quickstart/php
- https://developers.google.com/calendar/v3/push



## microsoft
- https://docs.microsoft.com/en-us/outlook/rest/php-tutorial#create-the-app
- https://docs.microsoft.com/en-us/previous-versions/office/office-365-api/api/version-2.0/notify-rest-operations
- https://github.com/jamesiarmes/php-ews
- https://support.microsoft.com/en-us/help/973627/microsoft-time-zone-index-values

## apple
- https://github.com/zubini/php_icloud_calendar


## caldav (ownclowd, nextcloud)
- some caldav client (https://github.com/sabre-io/davclient ?)

## related:
- https://kloudless.com/
- https://api.slack.com/

## automation
- automated workflows?

## message bus
- https://symfony.com/doc/current/components/messenger.html
- rabbitmq



# details

- account
    - account user
        - user
            - token - for authenticating to services (google, ms, etc)
            - calendars
            - events
            - api_access_token - for authenticating on api.<domain>
            - api_refresh_token - for authenticating on api.<domain>
            
            
- cron
    - https://github.com/lavary/crunz
    - * * * * * cd /project && vendor/bin/crunz schedule:run     
    - * * * * * cd /home/valeriu/Projects/calendar-api && vendor/bin/crunz schedule:run