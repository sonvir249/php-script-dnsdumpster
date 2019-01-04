<?php

// Turn off all error reporting
error_reporting(0);

// $domains is an array of domains.
$domains = ['google.com', 'facebook.com', 'linkedin.com', 'vivacanada.com'];

$copied_domains = [];
// let's read every domain...
foreach ($domains as $key => $domain) {
  $file_path = 'dnsfiles/' . $domain . '.xlsx';
  // Exist if DNS detail file already present for the domain.
  if (!file_exists($file_path)) {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://dnsdumpster.com/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "csrfmiddlewaretoken=kbaoos7fElQ5I4aXaGFugUnO6mh6QmZe&targetip=".$domain);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = [];
    $headers[] = "Authority: dnsdumpster.com";
    $headers[] = "Pragma: no-cache";
    $headers[] = "Cache-Control: no-cache";
    $headers[] = "Origin: https://dnsdumpster.com";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36";
    $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
    $headers[] = "Referer: https://dnsdumpster.com/";
    $headers[] = "Accept-Encoding: gzip, deflate, br";
    $headers[] = "Accept-Language: en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7,ar;q=0.6";
    $headers[] = "Cookie: csrftoken=kbaoos7fElQ5I4aXaGFugUnO6mh6QmZe; _ga=GA1.2.1239030569.1545929271; _gid=GA1.2.1857725251.1546416794; _gat=1";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch)."\n";
    }
    else {
      print "Copying {$domain} into dnsfiles directory.\n";
      // var_dump($result);
      $dom = new DOMDocument;
      $dom->loadHTML($result);
      $nodes = $dom->getElementsByTagName('a');
      /** @var \DOMNode $node */
      foreach ($nodes as $node) {
        if (strpos($node->attributes->getNamedItem('href')->nodeValue, 'https://dnsdumpster.com/static/xls/') !== FALSE) {
          $con = file_get_contents($node->attributes->getNamedItem('href')->nodeValue);
          $fp = fopen($file_path, 'w+');
          fwrite($fp, $con);
          fclose($fp);
          $copied_domains[$key] = $domain;
        }
      }
      curl_close($ch);
      print "File-> ".($key + 1).": Copied {$domain} into dnsfiles directory.\n\n";
    }
  }
}
if (!empty($copied_domains)) {
  $not_copied = array_diff($domains, $copied_domains);
  print "Data not found for following domains: \n";
  print implode("\n", $not_copied)."\n";
}
