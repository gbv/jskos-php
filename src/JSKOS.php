<?php
/**
 * jskos PHP library include file.
 *
 * This file includes all jskos library file. Please consider to use
 * autoloading instead.
 *
 * @code
 * <?php
 * require_once('src/JSKOS.php');
 * 
 * my $concept = new \JSKOS\Concept();
 * $concept->uri = "http://example.org/";
 * echo json_encode($concept);
 * ...
 * ?>
 * @endcode
 *
 * @file
 */


require_once('Data.php');
require_once('Record.php');
require_once('LabeledRecord.php');

require_once('Concept.php');
require_once('ConceptType.php');
require_once('ConceptScheme.php');
require_once('ConceptMapping.php');

require_once('Error.php');
require_once('Page.php');

require_once('Service.php');
require_once('ServiceEndpoint.php');

require_once('Server.php');
require_once('Client.php');

?>

