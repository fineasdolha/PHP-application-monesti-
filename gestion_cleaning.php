<?php
session_start();
require_once 'connection.php';
$db = new DAO();
$db->connection();
$sqlassoc = $db->getAssociations();
$associationList = $db->queryRequest($sqlassoc);

$infoCleaning = $db->getAllIntervention();





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
    <title>management cleaning</title>
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
          <a class="nav-link" href="gestion_places.php">Management places</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active " >Management cleaning</a>
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
    <h1>Management cleaning</h1>
</section>

    <!-- table for cleaning -->
    <section class="tableDesign"  style="margin-left:200px; margin-top:50px;margin-right:200px">
        <table id="cleaning" class="display text-light" style="width:100%">

        </table>

    </section>
    
    
    </section>



    <?php if (isset($_SESSION['message-error'])) {
        $_SESSION['message-error'] = null;
    } ?>
    <script type="text/javascript">
        //info pour cleaning
        let informationCleaning = <?php echo json_encode($infoCleaning) ?>;
        // alert(information.toString());
        $(document).ready(function() {
            let cleaning = $('#cleaning').dataTable({
                data: informationCleaning,
                responsive: true,

                columns: [{
                        title: 'last name'
                    },
                    {
                        title: 'first name'
                    },
                    {
                        title: 'working time'
                    },
                    {
                        title: 'date (Y-mm-dd)'
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