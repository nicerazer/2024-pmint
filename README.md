Recommended Specifications
MySQL 5.7+
PHP 8.2

Compatibility Concerns
MySQL 5.7+
MySQL 5.5~5.6: Due to a bug in MySQL, the package only works with strict mode disabled.
In your config/database.php file, set 'strict' => false, for the MySQL connection.
MariaDB 10.2+
PostgreSQL 9.3+
SQLite 3.25+: The limit is ignored on older versions of SQLite. This way, your application tests still work.
SQL Server 2008+
