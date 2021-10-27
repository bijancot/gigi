<div class="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <h2 class="page-desc">List of users</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <!-- <h5 class="card-title">Users</h5> -->
                    <table id="user" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>NISN</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Phone Number</th>
                                <th>School Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($users as $item) {
                                    if ($item->gender == 1) {
                                        $gender = 'Male';
                                    } else {
                                        $gender = 'Female';
                                    }
                                    echo '
                                        <tr>
                                            <td>'.$item->nisn.'</td>
                                            <td>'.$item->name.'</td>
                                            <td>'.$gender.'</td>
                                            <td>'.date("d F Y", strtotime($item->birth_date)).'</td>
                                            <td>'.$item->phone_number.'</td>
                                            <td>'.$item->school_class.'</td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>    
                                <th>NISN</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Phone Number</th>
                                <th>School Class</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#user').DataTable();
    });
</script>