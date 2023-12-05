
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="style.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>
    <script src="index.global.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@6.1.10/index.global.min.js'></script>
    
</head>
<body>
        <?php
        session_start();
        require_once('../connection.php');
        $db = new DAO;
        $db -> connection();
        $sql = 'SELECT * FROM `reservation`';
        $reservations = $db -> queryRequest($sql);
        $sched_res = [];
        
        foreach($reservations as $row){
            $row['string_start_datetime'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
            $row['string_end_datetime'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
            $sched_res[$row['id_reservation']] = $row;
    
        }
        
        $user_type= $_SESSION['user_type'];  
       
        ?>
        
        <div class="container py-5">
        <h1>Reservation calendar for <span id="department"><?php print $user_type ?></span> departments</h1>
        <div class="row">
            <div class="col-md-9">
                <div id="calendar" class="rounded-0 shadow p-1"></div>
            </div>
            <div class="col-md-3" id="form-rights">
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-dark text-light">
                        <h5 class="card-title">New reservation</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="save_schedule.php" method="post" id="schedule-form">
                                <input type="hidden" name="id" value="">
                                <div class="form-group mb-2">
                                    <label for="title" class="control-label">Title</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="start_datetime" class="control-label">Start</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="end_datetime" class="control-label">End</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="select" class="control-label">Choose the reservation type</label>
                                    <select class="form-control form-control-sm rounded-0" name="select" id="select" onchange="checkRecurrency()"  required>
                                        <option value="onetime" selected>One time reservation</option>
                                        <option value="recurrent">Recurrent reservation</option>
                                    </select>
                                    </div>
                                <div class="form-group mb-2" id="test">
                                <label for="end_recurrency" class="control-label">Last recurrency will be: </label>     
                                <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_recurrency" id="end_recurrency" required disabled>
                            </div>        
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--modal area -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Reservation details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Title</dt>
                            <dd id="title-modal-event" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description-modal-event" class=""></dd>
                            <dt class="text-muted">Start</dt>
                            <dd id="start-modal-event" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end-modal-event" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit-modal" data-id="">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete-modal" data-id="">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    


    <script src="script.js"></script>
</body>
</html>




