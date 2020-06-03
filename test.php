<?php

require __DIR__ . '/vendor/autoload.php';

echo 'Solarium ' . Solarium\Client::VERSION . "\n";

$config = array(
	'endpoint' => array(
		'localhost' => array(
			'host' => '127.0.0.1',
			'port' => 8983,
			'path' => '/',
			'core' => 'igo'
		)
	)
);

$client = new Solarium\Client(
		new Solarium\Core\Client\Adapter\Curl(),
		new Symfony\Component\EventDispatcher\EventDispatcher(),
		$config);


function ping($client) {
	$ping = $client->createPing();
	$result = $client->ping($ping);
}

function indexDocument($client, $fileName, $fileID, $date) {
	$query = $client->createExtract();
	$query->setFile(__DIR__ . '/' . $fileName);
	$query->setCommit(true);
	$query->setOmitHeader(false);

	$doc = $query->createDocument();
	$doc->setField('id', $fileID);
	$doc->setField('date', $date);
	$query->setDocument($doc);

	$result = $client->extract($query);

	echo $fileName . "\n";
}

function query1($client) {
	$query = $client->createSelect();
	$query->setQuery('virtueel');
	return $client->select($query);
}

function query2($client) {
	$query = $client->createSelect();
	$query->setQuery('BOSA');
	$query->createFilterQuery('maxdate')->setQuery('date:[* TO 2020-01-01T00:00:00Z]');
	return $client->select($query);
}


function showResults($resultset) {
	echo 'Found: ' . $resultset->getNumFound() . "\n";

	foreach ($resultset as $doc) {
		echo 'ID: ' . $doc->id . "\n";
		foreach ($doc as $key => $value) {
			if (is_array($value)) {
				$value = implode(', ', $value);
			}
			echo "\t" . $key . '=' . $value . "\n";
		}
	}
}

indexDocument($client, 'opendataportals_201904_nl.pdf', 'od2019', '2019-04-29');
indexDocument($client, 'opendataportals_202005_nl.pdf', 'od2020', '2020-05-01');

showResults(query1($client));
showResults(query2($client));

