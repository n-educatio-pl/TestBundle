#!/bin/sh
usage() {
cat << EOF
t [ OPTIONS path/to/test/file.php ]

t phpunit          Run all tests with configuration from app directory
t behat            Run all behat scenarios

OPTIONS:
    -c             Run tests with coverage
    -l             Run tests in loop
    -d             Run all test from directory
EOF
}

test() {
    vendor/bin/phpunit -c tmp/phpunit_configuration.xml.dist
    if [ "$COVERAGE" = "--coverage" ]; then
        cat tmp/codecoverage.txt
    fi
}

if [ $# = 0 ]; then
    usage
    exit
fi

COVERAGE=""
LOOP=0
DIRECTORY=0
FILES=""

while getopts “cd:lh” OPTION
do
    case $OPTION in
        c|l|d)
            if [ "$OPTION" = "c" ]; then
                COVERAGE="--coverage"
            elif [ "$OPTION" = "l" ]; then
                LOOP=1
            elif [ "$OPTION" = "d" ]; then
                DIRECTORY=1
            fi
            ;;
        h)
            usage
            exit
            ;;
        ?)
            usage
            exit
            ;;
    esac
done

if [ "$COVERAGE" = "--coverage" ] || [ $LOOP = 1 ] || [ $DIRECTORY = 1 ]; then
    shift
fi

FILES=$@

if [ "$1" = "phpunit" ]; then
    vendor/bin/phpunit -c app
    exit
elif [ "$1" = "behat" ]; then
    bin/behat @AcmeAnimalBundle $2 $3 $4 $5

    exit $?
fi

if [ $DIRECTORY = 1 ]; then
    php app/phpunit_current_dir.xml.dist.php $FILES $COVERAGE > tmp/phpunit_configuration.xml.dist
else
    php app/phpunit_fileAndTest.xml.dist.php $COVERAGE $FILES > tmp/phpunit_configuration.xml.dist
fi

if [ $LOOP = 1 ]; then
    while true
    do
        test
    done
else
    test
fi
