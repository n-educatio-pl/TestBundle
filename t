#!/bin/sh
usage() {
cat << EOF
t [OPTIONS] /path/to/test/file/or/directory

t phpunit              Run all tests with configuration from app directory
t behat                Run all behat scenarios

OPTIONS (connect all options together with single dash):
    -c                 Run tests with coverage
    -g <groupname>     Run tests with given group
    -l                 Run tests in loop
EOF
}

test() {
    phpunit -c tmp/phpunit_configuration.xml.dist $GROUPS
    if [ "$COVERAGE" = "--coverage" ]; then
        cat tmp/codecoverage.txt
    fi
    if [ $LOOP = 1 ]; then
        test
    fi
}

if [ $# = 0 ]; then
    usage
    exit
fi

COVERAGE=""
LOOP=0
DIRECTORY=0
GROUP=0
GROUPS=""
FILES=""

while getopts “cg:lh” OPTION
do
    case $OPTION in
        c|l|g)
            if [ "$OPTION" = "c" ]; then
                COVERAGE="--coverage"
            fi
            if [ "$OPTION" = "l" ]; then
                LOOP=1
            fi
            if [ "$OPTION" = "g" ]; then
                GROUP=1
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

if [ "$COVERAGE" = "--coverage" ] || [ $LOOP = 1 ] || [ $GROUP = 1 ]; then
    shift
fi

if [ $GROUP = 1 ]; then
    GROUPS="--group $1"
    shift
fi

if [ $# = 0 ]; then
    usage
    exit
fi

FILES=$@

if [ "$1" = "phpunit" ]; then
    phpunit -c app/
    exit
elif [ "$1" = "behat" ]; then
    bin/behat @AcmeAnimalBundle $2 $3 $4 $5

    exit $?
fi

if [ -d $FILES ]; then
    DIRECTORY=1
fi

if [ $DIRECTORY = 1 ]; then
    php app/phpunit_current_dir.xml.dist.php $FILES $COVERAGE > tmp/phpunit_configuration.xml.dist
else
    php app/phpunit_fileAndTest.xml.dist.php $COVERAGE $FILES > tmp/phpunit_configuration.xml.dist
fi

test
