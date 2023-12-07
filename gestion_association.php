<?php
session_start();
require_once 'connection.php';
$db = new DAO();
$db->connection();
$sqlassoc = $db->getAssociations();
$associationList = $db->queryRequest($sqlassoc);

$infoAssoc = $db->getAllAssociation();

if (isset($_POST['changeAssoc'])) {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $sql = "INSERT INTO `association`( `name_association`, `city_association`, `address_association`) VALUES ('$name','$city','$address')";
    $db->prepExec($sql);
    $_SESSION['message-error'] = 'Your association is registred';
    header('location:gestion_association.php');
}

if (isset($_POST['deleteAssoc'])) {
    $id_association = $_POST['idassoc'];


    $sql = "DELETE FROM `association` WHERE id_association LIKE '" . $id_association . "'";
    $db->prepExec($sql);
    $_SESSION['message-error'] = 'Your association is erased';
    header('location:gestion_association.php');
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
    <title>management association</title>
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
                        <a class="nav-link active " href="gestion_association.php">Management associations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_places.php">Management places</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Management cleaning</a>
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
        <h1>Management association</h1>
    </section>

    <!-- table for association -->
    <section class="tableDesign" style="margin-left:200px; margin-top:50px;margin-right:200px">
        <table id="association" class="display text-light">

        </table>

    </section>
    <section>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Management association</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-dark">

                        <form action="gestion_association.php" method="POST" class="container" style="max-width: 500px;">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input name="city" type="text" class="form-control" id="city">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input name="address" type="text" class="form-control" id="address">
                            </div>
                            <div class="mb-3 text-light">
                                <p>If you want to delete a place, this action is irreversible.</p><br>
                                <p> Just insert the ID of the place located in the table behind this window. </p>
                                <label for="idassoc" class="form-label">ID_PLACE</label>
                                <input name="idassoc" type="number" class="form-control" id="idassoc">
                            </div>

                    </div>
                    <div>
                        <button name="changeAssoc" type="submit" onchange="this.form.submit()" class="btn float-end  mt-2" style="background:#ecb21f; font-size:1em;margin-bottom:10px">Register</button>
                        <button name="deleteAssoc" type="submit" onchange="this.form.submit()" class="btn float-end  mt-2" style="background:#ecb21f; font-size:1em;margin-bottom:10px;margin-right:15px">Delete</button>

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
            management association
        </button>
    </section>
    </section>



    <?php if (isset($_SESSION['message-error'])) {
        $_SESSION['message-error'] = null;
    } ?>
    <script type="text/javascript">
        //info pour assoc
        let informationAsso = <?php echo json_encode($infoAssoc) ?>;
        // alert(information.toString());
        $(document).ready(function() {
            let assoc = $('#association').dataTable({
                data: informationAsso,
                responsive: true,

                columns: [{
                        title: 'ID ASSOCIATION'
                    },
                    {
                        title: 'Association'
                    },
                    {
                        title: 'city'
                    },
                    {
                        title: 'address'
                    }

                ],
                columnDefs: [{
                    targets: [0, 1, 2, 3],
                    className: 'dt-body-center',
                    className: 'compact',
                }],

            });

        });
    </script>
    <script type="text/javascript" src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>