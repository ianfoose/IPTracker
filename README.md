# IPTracker
A PHP IP logger, and notifier

## Setup

The timezone is set to EST, ou should set it to your local timezone<br>

To recieve emails when the IP address changes you will need to enter some email info, such as username, password, port, ssl, and smtp server.  

Set email login info<br>

```php
$email = ''; // SET
$password = ''; // SET
```

Set email sending info, smtp server, smtp port, ssl use.

```php
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl') # check for SMTP
->setUsername($email) 
->setPassword($password); 
```

## Installing

Run as a script or as a cronjob

### Script

In browser or by using php from the command line

```bash
php /path/to/script/ip_tracker.php
```

### Cronjob

Put job at bottom of file, you can change "*/30" to any interval, suggested is every 30 minutes.

```bash
crontab -e
*/30 * * * * php /path/to/script.php >/dev/null 2>&1
ctrl+o 
ctrl+x
```
