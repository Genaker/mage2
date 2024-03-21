# Mage is a Magento 2 library that makes magento backend easy again

**\Mage::** Facades provide an old good static interface to Magento classes that are available in the application’s Mage service container (a place to store variables and objects to use them when needed). Which mean that we can use functions without making an object from class.
Facades provide a "static" interface to classes available in the application's service container. Laravel ships with many facades, which provide access to all Magento 2 features.

Mage facades serve as "static proxies" to underlying classes in the service container, providing the benefit of a terse, expressive syntax while maintaining more flexibility than traditional magento methods.

# Mage library is not only facades!

Magento 2 sucks, and Mage is here to resolve this issue. Adobe killed Magento with the scum and overengenered bloatware. Mage adding additional nice development features not available with Magento 2 core.
* Fast easy accesible fasades
* Easy Logger
* Fast, accessible Object manager
* Symfony Dumper features
* Kint Backtrace and Debug
* Eloquent/Laravel Query Builder and ORM (provided by Laragento)

# Advantages of the Mage::Facades

* improve the readability and usability by masking interaction with more complex components behind a single and often simplified API
* provide a context-specific interface to more generic functionality
* serve as a launching point for a broader refactor of monolithic or tightly-coupled Magento systems in favor of more loosely-coupled code

We are decided to use a facade design pattern because the magento 2 system is very overengenered/complex and obfuscated - difficult to understand because the system has many interdependent classes. Mage::facade pattern hides the complexities of the Magento 2 system and provides a simpler interface to the developers. It typically involves a single wrapper class that contains a set of members required by the client. These members access the system on behalf of the facade clients and hide the implementation details.

# Mage DB facade 

Magento 2  interacts with a database using outdate Zend_DB library and slow legacy ORM. Mage DB2 based on Laravel/DB makes interacting with databases extremely simple and fast using raw SQL, a fluent Laravel query builder, and the Eloquent ORM in conjunction with Laragento package.

Also Laravel collections provide a variety of extremely powerful methods for mapping and reducing data. For more information check awesom Laravel documentation. 
https://laravel.com/docs/11.x/queries

Several example:
get all date from order table
$orders = DB2::table('sales_order');

specify select statements 

$users = DB2::table('users')
            ->select('name', 'email as user_email')
            ->get();

join 

$users = DB2::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();

insert

DB2::table('users')->insert([
    ['email' => 'picard@example.com', 'votes' => 0],
    ['email' => 'janeway@example.com', 'votes' => 0],
]);
