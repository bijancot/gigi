<div class="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <h2 class="page-desc">List of Users</h2>
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
                                <th>Action</th>
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
                                            <td>
                                                <a href="" class="mdReset" data-id="'.$item->nisn.'" data-name="'.$item->name.'" data-bdate="'.date("dmy", strtotime($item->birth_date)).'" data-toggle="modal" data-target="#mdReset"><i class="material-icons-outlined">restart_alt</i></a>
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
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Phone Number</th>
                                <th>School Class</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdReset" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="<?= site_url('user/resetPassword')?>" method="post">
            <div class="modal-body">
                    <!-- insert text -->
            </div>
            <div class="modal-footer">
                <input type="hidden" id="mdID" class="form-control" name="nisn">
                <input type="hidden" id="mdBDATE" class="form-control" name="bdate">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#user').DataTable();
    })
    $('#user tbody').on('click', '.mdReset', function(){
        const id = $(this).data('id')
        const bdate = $(this).data('bdate')
        const name = $(this).data('name')
        $('#mdID').val(id)
        $('#mdBDATE').val(bdate)
        $("#mdReset .modal-body").html('<p style="margin-bottom: 5px">Reset <mark>' + name + '</mark>\'s <code>password</code> to:</p><p><code>' + bdate + '</code></p>');
    })
</script>