<?php

class Employee
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "php_crud";
    public $con;

    //Connecting database

    public function __construct()
    {
        $this->con = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if(mysqli_connect_error()){
            trigger_error("Failed to connect to MYSQL:" . mysqli_connect_error());
        }else{
            return $this->con;
        }
    }

    // Insert customer data into customer table

    public function insertData($post)
    {
        $name = $this->con->real_escape_string($_POST['name']);
        $email = $this->con->real_escape_string($_POST['email']);
        $salary = $this->con->real_escape_string($_POST['salary']);
        $query="INSERT INTO customers (name,email,salary) VALUES ('$name','$email','$salary')";
        $sql = $this->con->query($query);
        if ($sql==true) {
            header("Location:display.php?msg1=insert");
        }else{
            echo "Registration failed try again!";

        }

    }

    // Fetch customer records for show listing

    public function displayData()
    {
        $query = "SELECT * FROM customers";
        $result =  $this->con->query($query);

        if($result->num_rows > 0){
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }else{
            echo "No found records in the data!";
        }
    }

    // Fetch single data for edit from customer table

    public function displayRecordById($id)
    {
        $query = "SELECT * FROM customers WHERE id = '$id'";
        $result =  $this->con->query($query);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
                return $row;
            }
            
        
        else{
            echo "No found records in the data!";
        }
    }

    // Update customer data into customer table

    public function updateRecord($postData)
    {
        $name = $this->con->real_escape_string($_POST['uname']);
        $email = $this->con->real_escape_string($_POST['uemail']);
        $salary = $this->con->real_escape_string($_POST['usalary']);
        $id = $this->con->real_escape_string($_POST['id']);

        if (!empty($id) && !empty($postData)){
            $query = "UPDATE customers SET name = '$name', email = '$email', salary = '$salary' WHERE id = '$id'";
            $sql =  $this->con->query($query);
            if ($sql==true) {
                header("Location:display.php?msg2=update");

            }else{
                echo "Registration updated failed try again";
            }
        }
    }

    // Delete customer data from customer table

    public function deleteRecord($id)
    {
        $query = "DELETE FROM customers WHERE id= '$id'";
        $sql = $this->con->query($query);

        if($sql==true){
            header("Location:display.php?msg3=delete");
        }else{
            echo "Record does not delete";
        }
    }
}