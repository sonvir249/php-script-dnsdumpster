<?php

/**
 * @file
 * File to merge all the downloaded files into one file.
 */

require 'vendor/autoload.php';

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

// ... and a writer to create the new file.
$writer = WriterFactory::create(Type::XLSX);
$writer->openToFile('merged_files.xlsx');
$header_processed = FALSE;

// Get all files.
$inputFileNames = array_slice(scandir('dnsfiles'), 2);

// Loop through all the remaining files in the list.
print "Merging all files in merged_files.xlsx.\n\n";

$sheet_count = 1;

foreach ($inputFileNames as $sheet => $inputFileName) {
  $file_ext = pathinfo($inputFileName, PATHINFO_EXTENSION);
  if ($file_ext === 'xlsx') {
    // We need a reader to read the existing file...
    $reader = ReaderFactory::create(Type::XLSX);
    $reader->open('dnsfiles/' . $inputFileName);
    $reader->setShouldFormatDates(TRUE);

    // let's read the entire spreadsheet...
    foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
      // Add sheets in the new file, as we read new sheets in the existing one.
      if ($sheetIndex !== 1) {
        $writer->addNewSheetAndMakeItCurrent();
      }

      $counter = 0;
      foreach ($sheet->getRowIterator() as $row) {
        if (($counter == 0) && ($header_processed)) {
          $counter++;
          continue;
        }

        if ($counter == 1) {
          array_unshift($row, str_replace('.xlsx', '', $inputFileName));
        }
        else {
          array_unshift($row, '');
        }

        // ... and copy each row into the new spreadsheet.
        $writer->addRow($row);
        $counter++;
      }
    }
    $reader->close();
    print "File -> {$sheet_count}: Merged {$inputFileName}.xlsx file in merged_files.xlsx.\n";
    $sheet_count++;
  }
}
$writer->close();
print "\nMerged all files in merged_files.xlsx.\n";
