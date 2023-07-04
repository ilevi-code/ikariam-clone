
# tables="ik_game rev105_trade_routes.sql  rev110_spy_messages.sql  rev110_user_messages.sql  rev116_users.sql islands.sql  rev110_spyes.sql         rev110_towns.sql         rev113_user_messages.sql"
tables="ik_game"
for name in $(echo $tables) ; do
    mysql --socket=mysql/mysql.sock -u root --password "" -e "create database $name"
    mysql --socket=mysql/mysql.sock -u root  $name < sql/$name.sql
done