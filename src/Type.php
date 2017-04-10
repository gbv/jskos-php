<?php declare(strict_types=1);

/**
 * Defines helper-method to handle data types.
 *
 *     JSKOS\Type::isURI($uri);
 *     JSKOS\Type::isURL($date);
 *     JSKOS\Type::isDate($date);
 *     JSKOS\Type::isLanguage($language);
 *     JSKOS\Type::isLanguageRange($range);
 *
 * @file
 */
namespace JSKOS\Type;

const IRI_PATTERN = '!^((?P<scheme>[a-z][a-z0-9+.-]*):)' .
        '((?P<doubleslash>//)(?P<authority>[^/?#]*))?(?P<path>[^?#]*)' .
        '((?<querydef>\?)(?P<query>[^#]*))?(#(?P<fragment>.*))?!';

const DATE_PATTERN = '!^(?P<year>-?\d\d\d\d)' .
        '(-((?P<month>\d\d)(' .
        '-(?P<day>\d\d)' .
        '(T\d\d:\d\d:\d\d(\.\d+)?)?' .
        '(Z|[+-]\d\d:\d\d)?' .
        ')?))?$!';

const LANGUAGE_PATTERN = '/^[a-z]{2,3}(?:-[A-Z]{2,3}(?:-[a-zA-Z]{4})?)?$/';

const LANGUAGE_RANGE_PATTERN = '/^([a-z]{2,3}(?:-[A-Z]{2,3}(?:-[a-zA-Z]{4})?)?)?-$/';

/**
 * Check whether a given string looks like an URI.
 */
function isURI(string $uri): bool
{
    return preg_match(IRI_PATTERN, $uri) === 1;
}

/**
 * Check whether a given string looks like an http/https URL.
 */
function isURL(string $url): bool
{
    return preg_match(IRI_PATTERN, $url, $match) and
           ($match[2] == 'http' or $match[2] == 'https');
}

/**
 * Check whether a given string looks like a date.
 */
function isDate(string $date): bool
{
    return preg_match(DATE_PATTERN, $date) === 1;
}

/**
 * Check whether a given string looks like a language tag.
 */
function isLanguage(string $language): bool
{
    return preg_match(LANGUAGE_PATTERN, $language) === 1;
}

/**
 * Check whether a given string looks like a language range.
 */
function isLanguageRange(string $range): bool
{
    return preg_match(LANGUAGE_RANGE_PATTERN, $range) === 1;
}
