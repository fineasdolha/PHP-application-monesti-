<?php
session_start();
require_once 'connection.php';
$db = new DAO();
$db->connection();
$infoPlaces = $db->getAllPlaces();

if (isset($_POST['changePlace'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO `places`(`name`, `description`) VALUES ('$name','$description')";
    $db->prepExec($sql);
    $_SESSION['message-error'] = 'Your association is registred';
    header('location:gestion_places.php');
}
if (isset($_POST['deletePlace'])) {
    $id_place = $_POST['idplace'];


    $sql = "DELETE FROM `places` WHERE id_place LIKE '" . $id_place . "'";
    $db->prepExec($sql);
    $_SESSION['message-error'] = 'Your association is erased';
    header('location:gestion_places.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <link href="style.css" rel="stylesheet">
    <title>management places</title>
</head>

<body>
    <section>
        <nav class="navbar navbar-expand-lg navbar-dark px-5" style="border:1px solid white">
            <a class="navbar-brand" href="#">Monestié</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="admin_homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendar/calendar.php">Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_personne.php">Management users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_association.php">Management associations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="gestion_places.php">Management places</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_cleaning.php">Management cleaning</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <form method="post">
                        <a class="btn" href="logout.php" style="background:#ecb21f; font-size:1em">Log out</a>
                    </form>
                </span>
            </div>
        </nav>
    </section>
    <!-- //message alerte -->
    <section>
        <?php if (isset($_SESSION['message-error'])) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message-error'];

                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
    </section>
    <section>
        <h1>Management places</h1>
    </section>

    <section class="tableDesign" style="margin-left:200px; margin-top:50px;margin-right:200px">
        <table id="place" class="display text-light" style="width:100%">

        </table>

    </section>



    <hr>

    <section>
        <!-- Modal register -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Management place</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-dark">

                        <form action="gestion_places.php" method="POST" class="container" style="max-width: 500px;">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" maxlength="150" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="mb-3 text-light">
                                <p>If you want to delete a place, this action is irreversible.</p><br>
                                <p> Just insert the ID of the place located in the table behind this window. </p>
                                <label for="idplace" class="form-label">ID_PLACE</label>
                                <input name="idplace" type="number" class="form-control" id="idplace">
                            </div>


                    </div>
                    <div>
                        <button name="changePlace" type="submit" onchange="this.form.submit()" class="btn float-end  mt-2" style="background:#ecb21f; font-size:1em;margin-bottom:10px;margin-right:5px">Register</button>
                        <button name="deletePlace" type="submit" onchange="this.form.submit()" class="btn float-end  mt-2" style="background:#ecb21f; font-size:1em;margin-bottom:10px;margin-right:15px">Delete</button>

                    </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
        </div>
    </section>
    <section>

        <button type="button" class="btn float-end mt-3 " style="background:#ecb21f; font-size:1em;margin-bottom:10px; margin-right:50px" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            management place
        </button>
    </section>
    </section>



    <?php if (isset($_SESSION['message-error'])) {
        $_SESSION['message-error'] = null;
    } ?>
    <script type="text/javascript">
        //info pour assoc
        let informationPlace = <?php echo json_encode($infoPlaces) ?>;
        console.log(informationPlace[0]['name']);
        // alert(information.toString());
        $(document).ready(function() {
            let place = $('#place').dataTable({
                data: informationPlace,
                responsive: true,

                columns: [{
                        title: 'ID PLACE'
                    },
                    {
                        title: 'name'
                    },
                    {
                        title: 'description'
                    }


                ],
                columnDefs: [{
                    targets: [0, 1, 2],
                    className: 'dt-body-center',
                    className: 'compact',
                }],

            });


        });
    </script>
    <script type="text/javascript" src="script.js"></script>

</body>

</html>