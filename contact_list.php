
<?php
include('admin_navbar.php');

class DatabaseHandler {
    private $connection;

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        // Create a database connection
        $this->connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function fetchAllResults() {
        // Modify your query to fetch all data and order by student name
        $query = "SELECT * FROM contact ORDER BY id ASC";

        $result = $this->connection->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
$dbHost = "localhost";
$dbUser = "ibdqwzul_albab";
$dbPass = "Abdulmujeeb_623";
$dbName = "ibdqwzul_albab";


$dbHandler = new DatabaseHandler($dbHost, $dbUser, $dbPass, $dbName);

$contactInfo = $dbHandler->fetchAllResults();

?>


<body>

    <div class="container">
        <h1 class="text-center mt-4 mb-4">Contact Records</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactInfo as $contact) { ?>
                    <tr>
                        <td><?php echo $contact['name']; ?></td>
                        <td><?php echo $contact['email']; ?></td>
                        <td><?php echo $contact['subject']; ?></td>
                        <td><?php echo $contact['message']; ?></td>
                        <td><?php echo $contact['date']; ?></td> 
                       
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php include ("albab_footer.php"); ?>
</body>
</html>
