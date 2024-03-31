<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$defaultIncludes = [];
try {
    echo "Starting DIR:" . __DIR__ . "\n";
    $startTime = microtime(true);
    echo "Start Magento Bootstrap\n";
    require __DIR__ . '/app/bootstrap.php';
    $params = $_SERVER;
    $params['MAGE_RUN_CODE'] = 'admin';
    $params['custom_entry_point'] = true;
    $bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $params);
    $endTime = microtime(true);
    $time = $endTime - $startTime;
    echo "End Magento Bootstrap in " . $time . " microseconds\n";
} catch (\Exception $e) {
    echo 'Autoload error: ' . $e->getMessage();
    exit(1);
}


$bootstrapPath = __DIR__ . '/include/bootstrap.php';
if (file_exists($bootstrapPath)) {
    $defaultIncludes[] = $bootstrapPath;
}

return [

    // PsySH uses symfony/var-dumper's casters for presenting scalars,
    // resources, arrays and objects. You can enable additional casters, or
    // write your own!
    'casters' => [
        'MyFooClass' => 'MyFooClassCaster::castMyFooObject',
    ],

    // By default, output contains colors if support for them is detected. To
    // override, use:
    //
    //   \Psy\Configuration::COLOR_MODE_FORCED to force colors
    //   \Psy\Configuration::COLOR_MODE_DISABLED to disable colors
    //   \Psy\Configuration::COLOR_MODE_AUTO to detect terminal support
    'colorMode' => \Psy\Configuration::COLOR_MODE_FORCED,

    // While PsySH ships with a bunch of great commands, it's possible to add
    // your own for even more awesome. Any Psy command added here will be
    // available in your Psy shell sessions.
    'commands' => [
        // The `parse` command is a command used in the development of PsySH.
        // Given a string of PHP code, it pretty-prints the PHP Parser parse
        // tree. It prolly won't be super useful for most of you, but it's there
        // if you want to play :)
        new \Psy\Command\ParseCommand,
    ],

    // "Default includes" will be included once at the beginning of every PsySH
    // session. This is a good place to add autoloaders for your favorite
    // libraries.
    'defaultIncludes' => $defaultIncludes,

    // If set to true, the history will not keep duplicate entries. Newest
    // entries override oldest. This is the equivalent of the
    // `HISTCONTROL=erasedups` setting in bash.
    'eraseDuplicates' => false,

    // While PsySH respects the current `error_reporting` level, and doesn't
    // throw exceptions for all errors, it does log all errors regardless of
    // level. Set `errorLoggingLevel` to `0` to prevent logging non-thrown
    // errors. Set it to any valid `error_reporting` value to log only errors
    // which match that level.
    'errorLoggingLevel' => E_ALL & ~E_NOTICE,

    // Always show array indexes (even for numeric arrays).
    'forceArrayIndexes' => true,

    // Sets the maximum number of entries the history can contain. If set to
    // zero, the history size is unlimited.
    'historySize' => 0,

    // PsySH defaults to interactive mode in a terminal, and non-interactive
    // mode when input is coming from a pipe.  To override, use:
    //
    //   \Psy\Configuration::INTERACTIVE_MODE_FORCED for interactive mode
    //   \Psy\Configuration::INTERACTIVE_MODE_DISABLED for non-interactive mode
    //   \Psy\Configuration::INTERACTIVE_MODE_AUTO to choose by connection type
    'interactiveMode' => \Psy\Configuration::INTERACTIVE_MODE_FORCED,

    // You can write your own tab completion matchers, too! Here are some that
    // enable tab completion for MongoDB database and collection names:
    'matchers' => [
        new \Psy\TabCompletion\Matcher\MongoClientMatcher,
        new \Psy\TabCompletion\Matcher\MongoDatabaseMatcher,
    ],

    // If this is not set, it falls back to `less`. It is recommended that you
    // set up `cli.pager` in your `php.ini` with your preferred output pager.
    'pager' => 'more',

    // Specify a custom prompt.
    'prompt' => '>>>',

    // Print var_export-style return values.
    //
    // This is set by the --raw-output (-r) flag, and really only makes sense
    // when non-interactive, e.g. executing stdin.
    'rawOutput' => false,

    // PsySH automatically inserts semicolons at the end of input if a statement
    // is missing one. To disable this, set `requireSemicolons` to true.
    'requireSemicolons' => true,

    // Set the shell's temporary directory location. Defaults to `/psysh` inside
    // the system's temp dir unless explicitly overridden.
    'runtimeDir' => __DIR__ . '/tmp',

    // Display an additional startup message. You can color and style the
    // message thanks to the Symfony Console tags. See
    // https://symfony.com/doc/current/console/coloring.html for more details.
    'startupMessage' => sprintf('<info>%s</info>', shell_exec('uptime')),

    // PsySH supports output themes, which control prompt strings, formatter
    // styles and colors, and compact output.
    //
    // There are three built-in themes: `modern`, `compact` or `classic`, which
    // can be specified directly:
    //
    //   'theme' => 'classic'
    'theme' => [
        // Use compact output. This can also be set by the --compact flag.
        'compact' => true,

        // The standard input prompt.
        'prompt' => '> ',

        // The input prompt used for multi-line input continuation.
        'bufferPrompt' => '. ',

        // Output prefix indicating lines replayed from history.
        'replayPrompt' => '- ',

        // Output prefix indicating the evaluated input's return value.
        'returnValue' => '= ',

        // Override theme formatting colors.
        //
        // Available colors:
        //   black, red, green, yellow, blue, magenta, cyan, white and default.
        // Available options:
        //   bold, underscore, blink, reverse and conceal.
        //
        // Note that the exact effect of these colors and options on output
        // depends on your terminal emulator application and settings.
        'styles' => [
            // name => [foreground, background, [options]],
            'error' => ['black', 'red', ['bold']],
        ],
    ],

    // Frequency of update checks when starting an interactive shell session.
    // Valid options are "always", "daily", "weekly", and "monthly".
    //
    // To disable update checks entirely, set to "never".
    'updateCheck' => 'daily',

    // Enable bracketed paste support. If you use PHP built with readline
    // (not libedit) and a relatively modern terminal, enable this.
    'useBracketedPaste' => true,

    // By default, PsySH will use a 'forking' execution loop if pcntl is
    // installed. This is by far the best way to use it, but you can override
    // the default by explicitly disabling this functionality here.
    'usePcntl' => true,

    // PsySH uses readline if you have it installed, because interactive input
    // is pretty awful without it. But you can explicitly disable it if you hate
    // yourself or something.
    //
    // If readline is disabled (or unavailable) then terminal input is subject
    // to the line discipline provided for TTYs by the OS, which may impose a
    // maximum line size (4096 chars in GNU/Linux, for example) with larger
    // lines being truncated before reaching PsySH.
    'useReadline' => true,

    // You can disable tab completion if you want to. Not sure why you'd
    // want to.
    'useTabCompletion' => true,

    // PsySH uses a couple of UTF-8 characters in its own output. These can be
    // disabled, mostly to work around code page issues. Because Windows.
    //
    // Note that this does not disable Unicode output in general, it just makes
    // it so PsySH won't output any itself.
    'useUnicode' => true,

    // Change output verbosity. This is equivalent to the `--verbose`, `-vv`,
    // `-vvv` and `--quiet` command line flags. Choose from:
    //
    //   \Psy\Configuration::VERBOSITY_QUIET (this is *really* quiet)
    //   \Psy\Configuration::VERBOSITY_NORMAL
    //   \Psy\Configuration::VERBOSITY_VERBOSE
    //   \Psy\Configuration::VERBOSITY_VERY_VERBOSE
    //   \Psy\Configuration::VERBOSITY_DEBUG
    'verbosity' => \Psy\Configuration::VERBOSITY_VERBOSE,

    // If multiple versions of the same configuration or data file exist, PsySH
    // will use the file with highest precedence, and will silently ignore all
    // others. With this enabled, a warning will be emitted (but not an
    // exception thrown) if multiple configuration or data files are found.
    //
    // This will default to true in a future release, but is false for now.
    'warnOnMultipleConfigs' => true,

    // Run PsySH without input validation. You don't want to set this to true.
    'yolo' => false,
];