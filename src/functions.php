<?php

namespace TwitchApi;

/**
 * Converts a string to a boolean.
 *
 * @param string $string
 * @param bool $returnNullAs
 * @return bool
 */
function string_to_boolean($string, $returnNullAs = false){
    $boolval = is_string($string)
                    ? filter_var($string, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                    : (bool) $string;

    return ($boolval === null && !$return_null ? false : $boolval);
}
