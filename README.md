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
#### Downloading domain DNS details
To download the DNS details in Excel sheet, pass array of domains in dnsdump.php on line number 12.

Example 
```
$domains = ['google.com', 'facebook.com', 'linkedin.com', 'vivacanada.com'];
```
Go to php-script-dnsdumpster direcotry from terminal.

Now run dnsdump.php script.

Example ```php dnsdump.php```

Output:
```
Copying google.com into dnsfiles directory.
File-> 1: Copied google.com into dnsfiles directory.

Copying facebook.com into dnsfiles directory.
File-> 2: Copied facebook.com into dnsfiles directory.

Copying linkedin.com into dnsfiles directory.
File-> 3: Copied linkedin.com into dnsfiles directory.

Copying vivacanada.com into dnsfiles directory.
File-> 4: Copied vivacanada.com into dnsfiles directory.

Data not found for following domains:
vivacanada.com
```

#### Merge downloaded domain details in one Excel
To merge the all files data into one file follow below steps.
From terminal run 
```
php merge.php
```

Outupt:

```
Merging all files in merged_files.xlsx.

File -> 1: Merged facebook.com.xlsx.xlsx file in merged_files.xlsx.
File -> 2: Merged google.com.xlsx.xlsx file in merged_files.xlsx.
File -> 3: Merged linkedin.com.xlsx.xlsx file in merged_files.xlsx.

Merged all files in merged_files.xlsx.
```

### Limitations
dnsdumspter allow to download 160 domain DNS files from single IP address for 24 hours.


# Contributing
Feel free to open issues, contribute and submit your Pull Requests. You can also ping me on Twitter (@sonvir249)
