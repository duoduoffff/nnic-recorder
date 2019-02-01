# nnic-recorder

This is the open source live programme recorder used by LingYin Studio in production, initially designed for recording the live stream of Lingyuan yousa, who is one of my favourite singers.

## requirements

your host should have systemd and php support.

## how to use

1. download the [php-mailer](https://github.com/PHPMailer/PHPMailer) program and extract it in the `./mailsender` directory.
2. modify the `conf.php` file. change roomid and fill in your email address.
3. put everything inside `/opt/nnic` directory.
4. `chmod +x request.php`
5. install service files in systemd configuration directory.
6. start the service.
