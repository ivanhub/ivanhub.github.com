<?php

class DumpHTTPRequestToFile {

	public function execute($targetFile) {

		$data = sprintf(
			"%s %s %s\n\nHTTP headers:\n",
			$_SERVER['REQUEST_METHOD'],
			$_SERVER['REQUEST_URI'],
			$_SERVER['SERVER_PROTOCOL']
		);

		foreach ($this->getHeaderList() as $name => $value) {
			$data .= $name . ': ' . $value . "\n";
		}

		$data .= "\nRequest body:\n";

		file_put_contents(
			$targetFile,
//    $data . file_get_contents('php://input') . "\n"
// 	  $data . file_get_contents('php://input') . "\n*************************************************************\n", FILE_APPEND
			$data . print_r($_REQUEST,true) . "\n*************************************************************\n", FILE_APPEND
		);

	//	echo("Done!\n\n");
	}

	private function getHeaderList() {

		$headerList = [];
		foreach ($_SERVER as $name => $value) {
			if (preg_match('/^HTTP_/',$name)) {
				// convert HTTP_HEADER_NAME to Header-Name
				$name = strtr(substr($name,5),'_',' ');
				$name = ucwords(strtolower($name));
				$name = strtr($name,' ','-');

				// add to list
				$headerList[$name] = $value;
			}
		}

		return $headerList;
	}
}


(new DumpHTTPRequestToFile)->execute('./dumprequest.txt');
//$date = new DateTime();
//rename("dumprequest.txt", "dumprequest" . $date->format('Y-m-d H:i:sP') . ".txt");
