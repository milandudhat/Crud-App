<?php
$insert = false;
$update = false;
$delete = false;

$servername = "localhost";
$username = "root";
$password  = "";
$database  = "note_crud";


$cont = mysqli_connect($servername,$username,$password,$database);
if(!$cont){
    die("error accur in connection" . mysqli_connect_error());
}


if(isset($_GET['delete'])){
    $sr_no = $_GET['delete'];
    // $delete = true;
    $sql = "DELETE FROM `notes` WHERE `notes`.`sr_no` = $sr_no";
    $result = mysqli_query($cont, $sql);
    if($result){
        $delete = true;
    }
    else{
        echo "We could not delete the record successfully" . mysqli_error($cont);
    }
  }
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST["edittitle"]) && isset($_POST["editdescription"])){
        $title = $_POST["edittitle"];
        $description = $_POST["editdescription"];
        $sr_no = $_POST["snoedit"];

        // Sql query to be executed
        $sql = "UPDATE `notes` SET `ntitle` = '$title' , `ndesc` = '$description' WHERE `notes`.`sr_no` = $sr_no";
        $result = mysqli_query($cont, $sql);
        if($result){
            $update = true;
        }
        else{
            echo "We could not update the record successfully" . mysqli_error($cont);
        } 
    }
    else{
        $title = $_POST["notetitle"];
        $description = $_POST["description"];  
        $sql = "INSERT INTO `notes` (`ntitle`, `ndesc`) VALUES ('$title', '$description')";


        $result = mysqli_query($cont , $sql);

        if($result){ 
            $insert = true;
        }
        else{
            echo "The record was not inserted successfully because of this error ---> ". mysqli_error($cont);
        } 
    }
}
?>





<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <title>Notes - using Crud</title>
</head>

<body>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit">
    Launch demo modal
  </button> -->

    <div class="modal fade" id="editmenu" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit">Edit menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="noteapp_crud.php" method="POST">
                        <div class="mb-3">
                            <input type="hidden" name="snoedit" id="snoedit">
                            <label for="editnotetitle" class="form-label">Note title</label>
                            <input type="text" class="form-control" id="edittitle" name="edittitle"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="editdescription">Note Description</label>
                            <textarea class="form-control my-2" id="editdescription" name="editdescription"
                                rows="3"></textarea>
                        </div>
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Notes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ContectUs</a>
                    </li>

                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <?php
    if($insert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note has been inserted successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <?php
    if($update){
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Success!</strong>  Your note has been updated successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <?php
    if($delete){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Success!</strong>  Your note has been deleted successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container my-5">
        <h2>Add a new note</h2>
        <form action="noteapp_crud.php" method="POST">
            <div class="mb-3">
                <label for="notetitle" class="form-label">Note title</label>
                <input type="text" class="form-control" id="notetitle" name="notetitle" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="description">Note Description</label>
                <textarea class="form-control my-2" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-1">Add Note</button>
        </form>
    </div>

    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sr-no</th>
                    <th scope="col">Note title</th>
                    <th scope="col">Note description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `notes`";
                    $result = mysqli_query($cont , $sql);
                    $srno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $srno = $srno + 1;
                        echo "<tr>
                        <th scope='row'>". $srno . "</th>
                        <td>" .$row['ntitle']."</td>
                        <td>" .$row['ndesc']."</td>
                        <td> <button class='edits btn btn-sm btn-primary' id=".$row['sr_no'].">Edit</button> <button class='deletes btn btn-sm btn-primary' id=".$row['sr_no'].">Delete</button>  </td>
                    </tr>";
                    }
                ?>

            </tbody>
        </table>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script> -->
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();

        });
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <script>
        edits = document.getElementsByClassName('edits')
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                // console.log("edit");
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;

                edittitle.value = title;
                editdescription.value = description;
                $('#editmenu').modal('toggle');

                snoedit.value = e.target.id;
                console.log(e.target.id)
            })
        })


        deletes = document.getElementsByClassName('deletes')
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                sr_no = e.target.id.substr();
                console.log(sr_no);
                if(confirm("are you sure delete this note")){
                    console.log("yes");
                    window.location = `noteapp_crud.php?delete=${sr_no}`;

                }
                else{
                    console.log("no");
                }
            })
        })
    </script>
</body>

</html>