<?php
$Module =& $Params['Module'];
$http =& eZHTTPTool::instance();

if ( $http->hasPostVariable('Skip') ){
    $Module->redirectToView( 'menu' );
}
include_once( 'kernel/common/template.php' );
$tpl =& templateInit();

if ( $http->hasPostVariable('Execute') )
{
    if( $http->hasPostVariable('sql') and $http->postVariable('sql') )
    {
        $tpl->setVariable( 'executed', 1 );
        $db =& eZDB::instance();
        $sql = trim( $http->postVariable('sql') );
        $queries = array();
        PMA_splitSqlFile( $queries, $sql, 0 );


        if ( count( $queries ) == 1 and preg_match( "/^select\s/i", $queries[0] ) )
        {
            $result =& $db->arrayQuery( $queries[0] );
        }
        else
        {
            foreach( $queries as $query )
            {
                $result =& $db->query( $query );
                if ( $result == false )
                    break;
            }
        }

        if ( $result == false )
        {
            $tpl->setVariable( 'success', 0 );
            $tpl->setVariable( 'error', $db->errorMessage() );
            $tpl->setVariable( 'errornumber', $db->errorNumber() );
            $tpl->setVariable( 'sql', $sql );
        }
        else
        {
            $tpl->setVariable( 'rows', count( $result ) );
            $tpl->setVariable( 'success', 1 );
        }
    }
    else
    {
        $tpl->setVariable( 'nosql', 1 );
    }

}


if ( !$http->hasPostVariable('Skip') )
{
$Result = array();
$Result['content'] = $tpl->fetch( "design:ezadmin/sqlquery.tpl" );
$Result['path'] = array( array( 'url' => false,
                        'text' => 'Database Query Manager' ) );
}
/**
 * Removes comment lines and splits up large sql files into individual queries
 *
 * Last revision: September 23, 2001 - gandon
 *
 * @param   array    the splitted sql commands
 * @param   string   the sql commands
 * @param   integer  the MySQL release number (because certains php3 versions
 *                   can't get the value of a constant from within a function)
 *
 * @return  boolean  always true
 *
 * @access  public
 */
function PMA_splitSqlFile(&$ret, $sql, $release)
{
    $sql          = trim($sql);
    $sql_len      = strlen($sql);
    $char         = '';
    $string_start = '';
    $in_string    = FALSE;
    $time0        = time();

    for ($i = 0; $i < $sql_len; ++$i) {
        $char = $sql[$i];

        // We are in a string, check for not escaped end of strings except for
        // backquotes that can't be escaped
        if ($in_string) {
            for (;;) {
                $i         = strpos($sql, $string_start, $i);
                // No end of string found -> add the current substring to the
                // returned array
                if (!$i) {
                    $ret[] = $sql;
                    return TRUE;
                }
                // Backquotes or no backslashes before quotes: it's indeed the
                // end of the string -> exit the loop
                else if ($string_start == '`' || $sql[$i-1] != '\\') {
                    $string_start      = '';
                    $in_string         = FALSE;
                    break;
                }
                // one or more Backslashes before the presumed end of string...
                else {
                    // ... first checks for escaped backslashes
                    $j                     = 2;
                    $escaped_backslash     = FALSE;
                    while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                        $escaped_backslash = !$escaped_backslash;
                        $j++;
                    }
                    // ... if escaped backslashes: it's really the end of the
                    // string -> exit the loop
                    if ($escaped_backslash) {
                        $string_start  = '';
                        $in_string     = FALSE;
                        break;
                    }
                    // ... else loop
                    else {
                        $i++;
                    }
                } // end if...elseif...else
            } // end for
        } // end if (in string)

        // We are not in a string, first check for delimiter...
        else if ($char == ';') {
            // if delimiter found, add the parsed part to the returned array
            $ret[]      = substr($sql, 0, $i);
            $sql        = ltrim(substr($sql, min($i + 1, $sql_len)));
            $sql_len    = strlen($sql);
            if ($sql_len) {
                $i      = -1;
            } else {
                // The submited statement(s) end(s) here
                return TRUE;
            }
        } // end else if (is delimiter)

        // ... then check for start of a string,...
        else if (($char == '"') || ($char == '\'') || ($char == '`')) {
            $in_string    = TRUE;
            $string_start = $char;
        } // end else if (is start of string)

        // ... for start of a comment (and remove this comment if found)...
        else if ($char == '#'
                 || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
            // starting position of the comment depends on the comment type
            $start_of_comment = (($sql[$i] == '#') ? $i : $i-2);
            // if no "\n" exits in the remaining string, checks for "\r"
            // (Mac eol style)
            $end_of_comment   = (strpos(' ' . $sql, "\012", $i+2))
                              ? strpos(' ' . $sql, "\012", $i+2)
                              : strpos(' ' . $sql, "\015", $i+2);
            if (!$end_of_comment) {
                // no eol found after '#', add the parsed part to the returned
                // array if required and exit
                if ($start_of_comment > 0) {
                    $ret[]    = trim(substr($sql, 0, $start_of_comment));
                }
                return TRUE;
            } else {
                $sql          = substr($sql, 0, $start_of_comment)
                              . ltrim(substr($sql, $end_of_comment));
                $sql_len      = strlen($sql);
                $i--;
            } // end if...else
        } // end else if (is comment)

        // ... and finally disactivate the "/*!...*/" syntax if MySQL < 3.22.07
        else if ($release < 32270
                 && ($char == '!' && $i > 1  && $sql[$i-2] . $sql[$i-1] == '/*')) {
            $sql[$i] = ' ';
        } // end else if

        // loic1: send a fake header each 30 sec. to bypass browser timeout
        $time1     = time();
        if ($time1 >= $time0 + 30) {
            $time0 = $time1;
            header('X-pmaPing: Pong');
        } // end if
    } // end for

    // add any rest to the returned array
    if (!empty($sql) && preg_match('@[^[:space:]]+@', $sql)) {
        $ret[] = $sql;
    }

    return TRUE;
} // end of the 'PMA_splitSqlFile()' function

// This function should be capable of repairing databases
function table_check_repair($dbname, $db, $host, $user, $password, $loglevel, $optimize_tables)
{
    global $cli;
    global $isQuiet;
    global $log;
    global $failed_tables;

    $connection = mysql_connect ($host, $user, $password);
      mysql_select_db($db);
    $check = "CHECK TABLE `$dbname` EXTENDED";
    $results = mysql_db_query($db, $check, $connection);
    $results = mysql_fetch_array ($results);

    if ( !$isQuiet )
                $cli->output(  "Checking table ".$dbname);

    if ($loglevel==2)
        $log .="\r\nChecking table ".$dbname.".\r\nTable results: $results[Table] -> $results[Msg_text]\r\n";
    
    
    if( stristr($results['Msg_text'], "closed the table properly") ) 
            {
        
        $repair = "REPAIR TABLE `$dbname` QUICK";
           $results = mysql_db_query($db, $repair, $connection);
        $results = mysql_fetch_array ($results);
            if ($loglevel==2)
                {
                $log .= "The table ".$dbname." has not been closed properly or is in use. A quick repair was attempted.\r\n";
                $log .= "Quick repair results: $results[Table] -> $results[Msg_text]\r\n";
                }
            }
    
            
        
            if ($results['Msg_text'] != "OK")
                {
                    
                $log .= "The table ".$dbname." did not check out well. A quick repair was attempted.\r\n";
                $failed_tables .= $dbname.", ";
                $repair1 = "REPAIR TABLE `$dbname` QUICK";
                $results = mysql_db_query($db, $repair1, $connection);
                $results = mysql_fetch_array ($results);
                $log .= "Quick repair results: $results[Table] -> $results[Msg_text]\r\n";
        
                if ($results['Msg_text'] != "OK")
                {
                    $log .= "The quick repair on table   ".$dbname." failed. A extended repair will be attempted.\r\n";
                    $repair2 = "REPAIR TABLE `$dbname` EXTENDED";
                    $results = mysql_db_query($db, $repair2, $connection);
                    $results = mysql_fetch_array ($results);
                    $log .= "Extended repair results: $results[Table] -> $results[Msg_text]\r\n";

                        if ($results['Msg_text'] != "OK")
                         {
                                $optimize_tables = false;
                                $log .= "The extended repair on table   ".$dbname." failed. The last repair that was attempted failed.\r\nTable ".$dbname." requires attention!! Check it with mysqlcheck or myisamchk.\r\n";
                         }
                 }
        
            }

    if ($optimize_tables)
    {
        $optimize = "OPTIMIZE TABLE `$dbname`";
        $results = mysql_db_query($db, $optimize, $connection);
        $results = mysql_fetch_array ($results);

        if ($loglevel==2)
            $log .= "Optimizing  ".$dbname.".\r\nOptimize results: $results[Table] -> $results[Msg_text].\r\n";
    }

}
?>