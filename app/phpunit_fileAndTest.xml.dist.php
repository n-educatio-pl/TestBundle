<?php
    if (count($argv) < 2) {
        throw new \InvalidArgumentException('at least one test file required');
    }
    $testFiles = $argv;
    if (isset($argv[1]) && $argv[1] === '--coverage') {
        $coverage = true;
        unset($testFiles[1]);
    } else {
        $coverage = false;
    }
    $codeDirs = array();
    array_shift($testFiles);
    foreach ($testFiles as $file) {
        $codeDir = $file;
        $codeDir = preg_replace('#/Tests/#', '/', $codeDir);
        $codeDir = preg_replace('#/[^/]+\.php$#', '/*', $codeDir);
        $codeDirs[] = $codeDir;
    }
    echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
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
    bootstrap                   = "<?php echo realpath(__DIR__);?>/bootstrap.php.cache" >

    <php>
        <server name="KERNEL_DIR" value="<?php echo realpath(__DIR__);?>" />
    </php>

    <testsuites>
        <testsuite name="Files Test Suite">
        <?php
            foreach ($testFiles as $file) {
                echo "<file>$file</file>\n";
            }
        ?>
        </testsuite>
    </testsuites>

    <filter>
        <whitelist>
            <directory suffix=".php">../src/*</directory>
            <?php
                $classes = array();
                foreach ($testFiles as $file) {
                    $covers = array();
                    $testFile = file_get_contents($file);
                    preg_match_all('/@covers (.*)/', $testFile, $covers);
                    foreach ($covers[1] as $cover) {
                        list($class) = explode('::', $cover);
                        $classes[] = '../src/' . str_replace('\\', '/', str_replace('\Neducatio', 'Neducatio', $class)) . '.php';
                    }
                    foreach (array_unique($classes) as $class) {
                        echo "<file>$class</file>\n";
                    }
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