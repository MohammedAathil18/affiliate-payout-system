Affiliate Payout System

PHP project implementing a 5-level affiliate commission system. Tracks users, their hierarchy, sales, and calculates payouts up to 5 levels.

Setup Instructions:

  Requirements
    PHP >= 7.4
    MySQL
    Apache / XAMPP
    1.Create the database:
        CREATE DATABASE affiliate_payout;
    2.Import the SQL file:
        mysql -u <username> -p affiliate_payout < database/affiliate_payout.sql
      
Configure DB Connection:

  Edit dp.php with your database credentials:
  
      $host = 'localhost';
      $dbname = 'affiliate_payout';
      $username = 'your_db_username';
      $password = 'your_db_password';
      
Test Instructions

Add a new user under an existing parent.

Record a sale for that user.

Check the commissions table to verify payouts.

You can use index.php for a ready-to-run demo.
