<?php
    if (count($argv) < 2) {
        throw new \InvalidArgumentException('at least one test file required');
    }
    $phpunitDir = realpath(__DIR__);
    $pwd = $argv[1];
    if (isset($argv[2]) && $argv[2] === '--coverage') {
        $coverage = true;
    } else {
        $coverage = false;
    }
    $directory = new RecursiveDirectoryIterator($pwd);
    $iterator = new RecursiveIteratorIterator($directory);
    $testFiles = new RegexIterator($iterator, '/^.+(Test|Should)\.php$/i', RecursiveRegexIterator::GET_MATCH);
    $codeDirs = array();
    $codeDir = '';
    foreach ($testFiles as $file) {
        $codeDir = $file[0];
        $codeDir = preg_replace('#/Tests/#', '/', $codeDir);
        $codeDir = preg_replace('#/[^/]+\.php$#', '/*', $codeDir);
        array_push($codeDirs, $codeDir);
        $codeDirs = array_unique($codeDirs);
    }
    print_r('<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL);
?>
<!-- http://www.phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit
    backupGlobals               = "false"
    backupStaticAttributes      = "false"
    colors                      = "true"
    convertErrorsToExceptions   = "true"
    convertNoticesToExceptions  = "true"
    convertWarningsToExceptions = "true"
    processIsolation            = "false"
    stopOnFailure               = "false"
    syntaxCheck                 = "false"
    bootstrap                   = "<?php echo $phpunitDir; ?>/bootstrap.php.cache" >

    <php>
        <server name="KERNEL_DIR" value="<?php echo $phpunitDir;?>" />
    </php>

    <testsuites>
        <testsuite name="Files Test Suite">
        <?php
            foreach ($testFiles as $file) {
                print_r('<file>'.$file[0].'</file>'.PHP_EOL);
            }
        ?>
        </testsuite>
    </testsuites>

    <filter>
        <whitelist processUncoveredFilesFromWhitelist="false">
            <directory suffix=".php">../src/*</directory>
            <?php
                foreach ($codeDirs as $dir) {
                    print_r("<directory suffix=\".php\">".$dir."</directory>".PHP_EOL);
                }
            ?>
            <exclude>
                <directory>../src/*/Tests</directory>
                <directory>../src/*/*/Tests</directory>
                <directory>../src/*/*/*/Tests</directory>
                <directory suffix="Should.php">../src/*</directory>
                <directory suffix="Test.php">../src/*</directory>
                <directory suffix="TestCase.php">../src/*</directory>
            </exclude>
        </whitelist>
    </filter>

    <?php
        if ($coverage) {
    ?>
    <logging>
        <log type="coverage-html" target="../build/coverage" title="Neducatio TestBundle"
             charset="UTF-8" yui="true" highlight="true" lowUpperBound="35" highLowerBound="70"/>
        <log type="coverage-text" target="../tmp/codecoverage.txt" title="Neducatio TestBundle" />
    </logging>
    <?php
        }
    ?>

</phpunit>