# FinalProject344
Files for the final project for CIS 344

To get started, ensure you have the latest version of XAMPP installed. Open the "Admin" page for the SQL server, here is where you can run the queries from real_estate_portal.sql.
This will initialize the database, set appropriate constraints and also create the procedures, trigger and view used for the project. 
(These can be run in succession or all at once, in the order of creating the database, then the procedures then the view)
**(Note that there are no password hashes included in the sample data, in order to test login/register functionality create a user using the register page then login with that registered users info.)**

Once you have one or more created users (preferably of different types) you will be able to access the different functions of the site. 
Agents can:
Add properties, view them and submit inquiries
Buyers/ renters can:
Only view properties and make inquiries
**(Note there is no functionality to purchase a property, but with the use of an SQL query in the PHPmyAdmin you can insert a transaction record to test the trigger for updating a properties status.)**
