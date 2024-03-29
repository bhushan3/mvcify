<?php


/**
 * Shows the emulated SQL query in a PDO statement. What it does is just extremely simple, but powerful:
 * It combines the raw query and the placeholders. For sure not really perfect (as PDO is more complex than just
 * combining raw query and arguments), but it does the job.
 *
 * @param string $raw_sql
 * @param array  $parameters
 * @return string
 */
function debugPDO($raw_sql, $parameters, $echo = true)
{
    $keys   = array();
    $values = $parameters;

    foreach ($parameters as $key => $value) {
        // Check if named parameters (':param') or anonymous parameters ('?') are used.
        if (is_string($key)) {
            $keys[] = '/' . $key . '/';
        } else {
            $keys[] = '/[?]/';
        }

        // Bring parameter into human-readable format.
        if (is_string($value)) {
            $values[$key] = "'" . $value . "'";
        } elseif (is_array($value)) {
            $values[$key] = implode(',', $value);
        } elseif (is_null($value)) {
            $values[$key] = 'NULL';
        }
    }

    /*
    echo "<br> [DEBUG] Keys:<pre>";
    print_r($keys);

    echo "\n[DEBUG] Values: ";
    print_r($values);
    echo "</pre>";
    */

    $raw_sql = preg_replace($keys, $values, $raw_sql, 1, $count);

    if ($echo) {
        echo '[ PDO DEBUG ]: ' . $raw_sql;
        exit;
    } else {
        return $raw_sql;
    }
}

function esc_html($text, $echo = true)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
