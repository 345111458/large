#!/bin/bash

# 每5秒去访问一下这里面的链接
step=3 # 间隔的秒数 ， 不能大于60

if [ -z $1 ];then
    str='en'
else
    str="$1"
fi

if [ -z $2 ];then
    time=7200
else
    time=$2
fi



for ((i = 0; i < time; i = (i + step))); do

  cd /home/vagrant/Code/atc
  php artisan command:LangTranslate $str
  echo $i
  sleep $step
done
exit 0
