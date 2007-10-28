<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * 
 * The first greek open source PHP5 framework, fast, with small
 * footprint and easily extensible.<br>
 * Το πρώτο ελληνικό framework PHP5 ανοικτού κώδικα, γρήγορο,
 * μικρό σε μέγεθος και εύκολα επεκτάσιμο.<br>
 *
 *
 * @package     leaf
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


global $config;
$config = array();

/*
 * Host name.
 *
 * Όνομα εξυπηρετητή.
 */
$config['hostname']  = "http://hideo";

/*
 * The subdirectory in your htdocs (usually), where leaf Framework`s
 * index.php is located.
 * 
 * Υποκατάλογος στο htdocs (συνήθως), όπου βρίσκεται το index.php
 * του leaf Framework.
 */
$config['base_dir']  = "/leaf/";

/*
 *
 *
 *
 */
$config['locale'] = "el";

/*
 * The base url - created automatically.
 *
 * Η βασική διεύθυνση - δημιουργήτε αυτόματα.
 */
$config['base_url']	 = $config['hostname'] . $config['base_dir'];

/*
 * Virtual file extension, shown in the address. (Optional).
 *
 * Εικονική επέκταση αρχείου, εμφανίσιμη στην διεύθυνση. (Προαιρετικό).
 */
#$config['url_suffix']= "";

/*
 * Default encoding used when necesery.
 *
 * Κωδικοποίηση που θα χρησιμοποιείται όταν χρειάζεται.
 */
$config['charset'] = "utf-8";

/*
 *
 * "Yes", "No"
 */
$config['allow_endorsed'] = "No";

/*
 *
 *
 * "Yes", "No"
 */
$config['allow_hooks'] = "No";

/*
 * Enable/Disable query strings.
 * (legal values: Yes/No).
 *
 * Ενεργοποίηση/Απένεργοποίηση των query strings.
 * (δεκτές τιμές: Yes/No).
 */
$config['allow_query_strings'] = "Yes";

/*
 * Allowed characters in the query strings.
 * Do _NOT_ set to nothing, unless you are aware of the
 * consicouences.
 *
 * Επιτρεπόμενοι χαρακτήρες στα query strings.
 * _Μην_ αφήσετε κενή την μεταβλητή, εκτός και εάν έχετε
 * συνείδηση των επιπλοκών.
 */
$config['allow_query_string_chars'] = "a-z0-9-_";

/*
 * Allowed characters in the URIs. The default values are
 * the best out there.
 * Change only if sure and do _NOT_ set to nothing,
 * unless you are aware of the consicouences.
 *
 * Επιτρεπόμενοι χαρακτήρες στα URI. Οι τιμές εξορισμού,
 * είναι οι προτοιμόμενες.
 * Αλλάξτε την τιμή, μόνο εάν ξέρετε τι κάνετε και σε καμία
 * περίπτωση μην αφήσετε κενή την μεταβλητή εκτός και εάν
 * έχετε συνείδηση των επιπλοκών.
 */
$config['allow_uri_chars'] = "a-z0-9-/_:+~%*";

/*
 * Possible values inclue
 *
 * "gz", "tidy", "normal"
 */
$config['output_handler'] = "Normal";

/*
 * Which messages will be logged. Possible values are listed.
 *
 * Ποιά μηνύματα θα καταχωρηθούν. Ακολουθούν οι πιθανές τιμές.
 *
 *
 * "All", "Debug", "Warning", "Info", "None"
 */
$config['log_level'] = "None";

/*
 * Whether to show a summary of debug statistics.
 * Legal values follow.
 *
 * Εμφάνιση η απόκρυψη στατιστικών πληροφοριών.
 * Ακολουθούν οι πιθανές τιμές.
 *
 * "Yes", "No"
 */
$config['enable_debug_stats'] = "Yes";

?>
