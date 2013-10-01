#!/bin/sh
echo "" > tmp/codecoverage.txt
echo "" > tmp/phpunit_singlefile.xml.dist
if [ "$1" = "" ]
then
  echo "Usage:"
  echo "t phpunit:                Run all phpunit tests"
  echo "t behat:                  Run all behat tests"
  echo "t path/to/testedFile.php: Run test for given file"

elif [ "$1" = "behat" ]
then
  status=0

  bin/behat @AcmeAnimalBundle $2 $3 $4 $5
  lastStatus=$?
  if [ $lastStatus -ne 0 ]; then status=$lastStatus; fi

  exit $status
elif [ "$1" = "phpunit" ]
then
  vendor/bin/phpunit -c app $2 $3 $4 $5
  exit $?
elif [ "$1" = "phpunitcoverage" ]
then
  vendor/bin/phpunit --configuration app/phpunitCoverage.xml.dist $2 $3 $4 $5
  exit $?
else
  php app/phpunit_singlefile.xml.dist.php "$1" > tmp/phpunit_singlefile.xml.dist
  while true
  do
    vendor/bin/phpunit -c tmp/phpunit_singlefile.xml.dist $2 $3 $4 $5
    cat tmp/codecoverage.txt
  done
fi

# za duzo miejsca
# cat tmp/codecoverage.txt
echo ""

