<?php
/**
 * @authors: liaolingjia (liaolingjia@dasheng.tv)
 * @date: 2017-11-22 12:01
 * @version
 */
//停掉mysql-main

//判断是否有目录
echo "判断是否有目录mysql-slave1或mysql-slave2";
/**
 * @authors: liaolingjia (liaolingjia@dasheng.tv)
 * @date: 2017-11-22 12:01
 * @version
 */
//停掉mysql-main

//判断是否有目录
echo "判断是否有目录mysql-slave1或mysql-slave2".PHP_EOL;
$work_root_dir = __DIR__."../..";
$has_s1 = is_dir($work_root_dir."/mysql-slave1");
$has_s2 = is_dir($work_root_dir."/mysql-slave2");
$slave_root_dir = "";
$slave_name = "";
$cur_slave_name = "";
if(!$has_s1){
    echo "没有目录mysql-slave1 ，创建目录mysql-slave1".PHP_EOL;
    $slave_root_dir = "$work_root_dir/mysql-slave1";
    $slave_name = "slave1";
    $cur_slave_name =  "slave2";
    system("cp $work_root_dir/mysql-slave $slave_root_dir");
}
else{
    echo "有目录mysql-slave1，创建目录mysql-slave2".PHP_EOL;
    $slave_root_dir = "$work_root_dir/mysql-slave2";
    $slave_name = "slave2";
    $cur_slave_name =  "slave1";
    system("cp $work_root_dir/mysql-slave $slave_root_dir");
}
echo "创建目录完毕，新数据会放在{$slave_root_dir}下".PHP_EOL;
echo "docker stop mysql-main".PHP_EOL;
system("docker stop mysql-main");
echo "mysql-main stoped".PHP_EOL;
echo "copy 'mysql data file' from   'mysql-main data' to '$slave_name data'".PHP_EOL;
system("cp  $work_root_dir/mysql-main/data $slave_root_dir/data");
echo "cp completed".PHP_EOL;
echo "docker rm -f $slave_name ".PHP_EOL;
system("docker rm -f mysql-$cur_slave_name");
echo "docker rm completed ".PHP_EOL;
echo "docker run  mysql-$slave_name ".PHP_EOL;
system("docker run -e MYSQL_ROOT_PASSWORD=dashengrep -e MYSQL_USER=dashengrep -e MYSQL_PASSWORD=dashengrep   -p 3306:3306  -v $slave_root_dir/config:/etc/mysql  -v $slave_root_dir/data:/var/lib/mysql  --name mysql-$slave_name -d  mysql");
echo "All done , enjoy it... ".PHP_EOL;
$work_root_dir = __DIR__."../..";
$has_s1 = is_dir($work_root_dir."/mysql-slave1");
$has_s2 = is_dir($work_root_dir."/mysql-slave2");
$slave_root_dir = "";
$slave_name = "";
$cur_slave_name = "";
if(!$has_s1){
    echo "没有目录mysql-slave1 ，创建目录mysql-slave1".PHP_EOL;
    $slave_root_dir = "$work_root_dir/mysql-slave1";
    $slave_name = "slave1";
    $cur_slave_name =  "slave2";
    system("cp $work_root_dir/mysql-slave $slave_root_dir");
}
else{
    echo "有目录mysql-slave1，创建目录mysql-slave2".PHP_EOL;
    $slave_root_dir = "$work_root_dir/mysql-slave2";
    $slave_name = "slave2";
    $cur_slave_name =  "slave1";
    system("cp $work_root_dir/mysql-slave $slave_root_dir");
}
echo "创建目录完毕，新数据会放在{$slave_root_dir}下".PHP_EOL;
echo "docker stop mysql-main".PHP_EOL;
system("docker stop mysql-main");
echo "mysql-main stoped".PHP_EOL;
echo "copy 'mysql data file' from   'mysql-main data' to '$slave_name data'".PHP_EOL;
system("cp  $work_root_dir/mysql-main/data $slave_root_dir/data");
echo "cp completed".PHP_EOL;
echo "docker rm -f $slave_name ".PHP_EOL;
system("docker rm -f mysql-$cur_slave_name");
echo "docker rm completed ".PHP_EOL;
echo "docker run  mysql-$slave_name ".PHP_EOL;
system("docker run -e MYSQL_ROOT_PASSWORD=dashengrep -e MYSQL_USER=dashengrep -e MYSQL_PASSWORD=dashengrep   -p 3306:3306  -v $slave_root_dir/config:/etc/mysql  -v $slave_root_dir/data:/var/lib/mysql  --name mysql-$slave_name -d  mysql");
echo "All done , enjoy it... ".PHP_EOL;