#!/bin/bash
set -e
while true
do
  curl -f 'http://localhost:8080/yii-1.1.23.445827/testdrive/index.php'
  curl -f 'http://localhost:8080/yii-1.1.23.445827/testdrive/index.php?r=test/createnew'
  curl -f 'http://localhost:8080/yii-1.1.23.445827/testdrive/index.php?r=test/createnew'

  curl -f 'http://localhost:8080/yii-1.1.23.445827/testdrive/index.php?r=test/loadandupdate'

  curl -f 'http://localhost:8080/yii-1.1.23.445827/testdrive/index.php?r=test/deleteone'

  #sleep 1
done
