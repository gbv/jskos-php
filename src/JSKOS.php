<?php
/**
 * jskos PHP library include file.
 *
 * @see https://gbv.github.io/jskos/
 *
 * This file includes all jskos library files. Please consider to use autoloading instead.
 *
 * @code
 * <?php
 * require_once('src/JSKOS.php');
 * 
 * my $concept = new JSKOS\Concept();
 * $concept->uri = "http://example.org/";
 * echo json_encode($concept);
 * ...
 * ?>
 * @endcode
 *
 * @file
 */

require_once('PrettyJsonSerializable');
require_once('Object.php');
require_once('Item.php');

require_once('Concept.php');
require_once('ConceptType.php');
require_once('ConceptScheme.php');
require_once('ConceptBundle.php');
require_once('Mapping.php');
require_once('Concordance.php');
require_once('Registry.php');

require_once('Error.php');

require_once('Page.php');

require_once('Service.php');

require_once('Response.php');

require_once('Server.php');
require_once('Client.php');
