<?php
include_once("../Models/M_Student.php");

class Controller_Student
{
    public function invoke()
    {
        if (isset($_REQUEST['action'])) {
            switch ($_REQUEST['action']) {
                case 'add': {
                        $modelStudent = new Model_Student();
                        $student = new Entity_Student($_REQUEST['ID'], $_REQUEST['name'], $_REQUEST['age'], $_REQUEST['university']);
                        $result = $modelStudent->addStudent($student);

                        if ($result == 1) {
                            $this->allStudents();
                        } else {
                            echo 'Thêm sinh viên thất bại.';
                        }
                    }
                    break;
                case 'update': {
                        $modelStudent = new Model_Student();
                        $student = new Entity_Student($_REQUEST['ID'], $_REQUEST['name'], $_REQUEST['age'], $_REQUEST['university']);
                        $result = $modelStudent->updateStudent($student);

                        if ($result == 1) {
                            $students = $modelStudent->getAllStudents();
                            include_once('../View/StudentList_update.html');
                        } else {
                            echo 'Bug ha';
                        }
                    }
                    break;
                case 'filter': {
                        $modelStudent = new Model_Student();
                        $students = $modelStudent->filterStudents($_REQUEST['field'], $_REQUEST['input']);
                        if (sizeof($students) > 0) {
                            include_once('../View/StudentList_filter.html');
                        } else {
                            echo 'Bug ha';
                        }
                    }
                    break;

                default:
                    echo '404 NOT FOUND Action = ' . $_REQUEST['action'];

                    break;
            }

            return;
        }

        if (isset($_REQUEST['mod1'])) {
            $modelStudent = new Model_Student();
            $students = $this->getAllIDSV();
?>
            <script>
                function checkValidIDSV() {
                    var IDSVs = [];
                    <?php
                    for ($i = 1; $i <= sizeof($students); $i++) {
                    ?>
                        IDSVs.push('<?php echo $students[$i]->id ?>')
                    <?php
                    }
                    ?>

                    var IDSVnew = document.formChenSV.ID.value;
                    console.log(IDSVnew);

                    if (IDSVs.includes(IDSVnew)) {
                        alert('Tồn tại sinh vien có ID này rồi');
                        document.formChenSV.ID.value = "";
                        document.formChenSV.ID.focus();
                    }

                }
            </script>
<?php
            include_once('../View/StudentForm.html');

            return;
        }

        if (isset($_REQUEST['mod2'])) {
            $modelStudent = new Model_Student();

            if (isset($_REQUEST['stdid'])) {
                $student = $modelStudent->getStudent($_GET['stdid']);
                include_once('../View/StudentForm_update.html');
                return;
            }

            $students = $modelStudent->getAllStudents();
            include_once('../View/StudentList_update.html');

            return;
        }


        if (isset($_REQUEST['mod3'])) {
            $modelStudent = new Model_Student();

            if (isset($_REQUEST['stdid'])) {
                $student = $modelStudent->deleteStudent($_GET['stdid']);
            }

            $students = $modelStudent->getAllStudents();
            include_once('../View/StudentList_delete.html');

            return;
        }

        if (isset($_REQUEST['mod4'])) {
            $modelStudent = new Model_Student();
            include_once('../View/FilterForm.html');
            return;
        }

        if (isset($_REQUEST['stdid'])) {
            $modelStudent = new Model_Student();
            $student = $modelStudent->getStudent($_GET['stdid']);
            include_once('../View/StudentDetail.html');
            return;
        } else {
            $this->allStudents();
        }
    }

    private function allStudents()
    {
        $modelStudent = new Model_Student();

        $students = $modelStudent->getAllStudents();
        include_once('../View/StudentList.html');
    }

    private function getAllIDSV()
    {
        $modelStudent = new Model_Student();

        return $modelStudent->getAllStudents();
    }
}

$C_controller = new Controller_Student();
$C_controller->invoke();
