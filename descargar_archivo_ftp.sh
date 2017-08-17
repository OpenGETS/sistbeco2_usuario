#!/bin/bash
host='200.68.8.37'
usuario='beco'
password='4be#40co'
ftp -ni -v $host << EOS
user $usuario $password
prompt
bin
cd /infoemx/
lcd /var/www/html/sistbeco2_usuario/infoemx/dumps
put login_accesos_20170810.txt
bye
EOS