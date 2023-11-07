<?php
include_once("../Models/E_Student.php");
class Model_Student
{
    public function __construct()
    {
    }

    public function getAllStudents()
    {
        $link = mysqli_connect("localhost", "root", "") or die("Khong the ket noi den CSDL MySQL");

        mysqli_select_db($link, "dulieu");

        $query = "select * from sinhvien";

        $result = mysqli_query($link, $query);

        $i = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["ID"];
            $age = $row["age"];
            $name = $row["name"];
            $university = $row["university"];

            while ($i != $id) {
                $i++;
            }

            $students[$i++] = new Entity_Student($id, $name, $age, $university);
        }

        return $students;
    }

    public function getStudent($id)
    {
        $allStudents = $this->getAllStudents();
        return $allStudents[$id];
    }

    public function addStudent(Entity_Student $student)
    {
        $link = mysqli_connect("localhost", "root", "") or die("Khong the ket noi den CSDL MySQL");

        mysqli_select_db($link, "dulieu");

        $query = "INSERT INTO `sinhvien`(`ID`, `name`, `age`, `university`) VALUES ('" . $student->id . "','" . $student->name . "','" . $student->age . "','" . $student->university . "')";
        echo $query;
        $result = mysqli_query($link, $query);

        return $result;
    }

    public function updateStudent(Entity_Student $student)
    {
        $link = mysqli_connect("localhost", "root", "") or die("Khong the ket noi den CSDL MySQL");

        mysqli_select_db($link, "dulieu");

        $query = "UPDATE `sinhvien` SET `name`='" . $student->name . "',`age`='" . $student->age . "',`university`='" . $student->university . "' WHERE ID = '" . $student->id . "'";
        echo $query;
        $result = mysqli_query($link, $query);

        return $result;
    }

    public function deleteStudent($id)
    {
        $link = mysqli_connect("localhost", "root", "") or die("Khong the ket noi den CSDL MySQL");

        mysqli_select_db($link, "dulieu");

        $query = "DELETE FROM `sinhvien` WHERE `sinhvien`.`ID` LIKE '" . $id . "'";
        echo $query;
        $result = mysqli_query($link, $query);

        return $result;
    }

    public function filterStudents($field, $value)
    {
        $link = mysqli_connect("localhost", "root", "") or die("Khong the ket noi den CSDL MySQL");

        mysqli_select_db($link, "dulieu");

        $query = "SELECT * FROM `sinhvien` WHERE " . $field . " LIKE '%" . $value . "%'";
        echo $query;
        $result = mysqli_query($link, $query);
        $i = 0;

        $students = new ArrayObject();

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["ID"];
            $age = $row["age"];
            $name = $row["name"];
            $university = $row["university"];

            $students[++$i] = new Entity_Student($id, $name, $age, $university);
        }
        return $students;
    }
}
