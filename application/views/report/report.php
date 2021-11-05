<div class="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <h2 class="page-desc">List of <span class="badge badge-info">ONGOING</span> Reports</h2>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($reports as $item) {
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
                                            <td>';
                                    if ($item->created_at) {
                                        echo '<a href="'.site_url('report/detail/'.$item->report_id).'"><i class="material-icons-outlined">info</i></a>';
                                    } else {
                                        echo '<a style="color: gray;"><i class="material-icons-outlined">info</i></a>';
                                    }
                                    echo '
                                                <a href="" class="mdCancel" data-id="'.$item->report_id.'" data-name="'.$item->name.'" data-toggle="modal" data-target="#mdCancel"><i class="material-icons-outlined">cancel</i></a>
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
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdCancel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="<?= site_url('report/changeStatus')?>" method="post">
            <div class="modal-body">
                    Make this report status to <code>canceled.</code>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="mdID" class="form-control" name="report_id">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#report').DataTable()
    })
    $('#report tbody').on('click', '.mdCancel', function(){
        const id = $(this).data('id')
        const name = $(this).data('name')
        $('#mdID').val(id)
        $("#mdCancel .modal-body").html('Make <mark>' + name + '</mark>\'s report status to <code>canceled.</code>');
    })
</script>