# PHP script for dnsdumpster.com

Unofficial PHP CLI script to download DNS details from https://dnsdumpster.com/

DNSDumpster is a domain research tool to find host related information. It’s HackerTarget.com project.

Not just subdomain but it gives you information about DNS server, MX record, TXT record and nice mapping of your domain.


### Install from the sources
Clone the repo
```
git clone git@github.com:sonvir249/php-script-dnsdumpster.git
```

### Install requirements
```
composer install
```

### Usage

To download the DNS details in Excel sheet, pass array of domains in dnsdump.php on line number 12.

Example 
```
$domains = ['google.com', 'facebook.com', 'linkedin.com', 'vivacanada.com'];
```
Go to php-script-dnsdumpster direcotry from terminal.

Now run dnsdump.php script.

Example ```php dnsdump.php```

### Limitations
dnsdumspter allow to download 160 domain DNS files from single IP address for 24 hours.


# Contributing
Feel free to open issues, contribute and submit your Pull Requests. You can also ping me on Twitter (@sonvir249)
