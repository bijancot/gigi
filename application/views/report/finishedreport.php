<div class="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <h2 class="page-desc">List of Finished Reports</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <!-- <h5 class="card-title">Users</h5> -->
                    <table id="report" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>NISN</th>
                                <th>Name</th>
                                <th>Day</th>
                                <th>Latest Report</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($reports as $item) {
                                    if ($item->status == 'finished') {
                                        $status = '<span class="badge badge-success">FINISHED</span>';
                                    } else {
                                        $status = '<span class="badge badge-secondary">NULL</span>';
                                    }
                                    if ($item->created_at) {
                                        $created_at = date("d F Y", strtotime($item->created_at));
                                    } else {
                                        $created_at = "Haven't submit";
                                    }
                                    echo '
                                        <tr>
                                            <td>'.$item->nisn.'</td>
                                            <td>'.$item->name.'</td>
                                            <td>'.$item->day.'</td>
                                            <td>'.$created_at.'</td>
                                            <td>'.$status.'</td>
                                            <td>';
                                    if ($item->created_at) {
                                        echo '<a href="'.site_url('report/detail/'.$item->report_id).'"><i class="material-icons-outlined">info</i></a>';
                                    } else {
                                        echo '<a style="color: gray;"><i class="material-icons-outlined">info</i></a>';
                                    }
                                    echo '
                                            </td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>NISN</th>
                                <th>Name</th>
                                <th>Day</th>
                                <th>Latest Report</th>
                                <th>Status</th>
                                <th>Action</th>
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
        $('#report').DataTable();
    });
</script>