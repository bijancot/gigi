<div class="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <?php 
                    if ($reports) {
                        if ($reports[0]->progress == 'ongoing') {
                            $progress = '<span class="badge badge-info">Ongoing</span>';
                        } else if ($reports[0]->progress == 'canceled') {
                            $progress = '<span class="badge badge-warning">Canceled</span>';
                        } else if ($reports[0]->progress == 'finished') {
                            $progress = '<span class="badge badge-success">Finished</span>';
                        } else {
                            $progress = '<span class="badge badge-secondary">NULL</span>';
                        }
                    } else {
                        $progress = '<span class="badge badge-secondary">NULL</span>';
                    }
                ?>
                <h2 class="page-desc">List of <?= empty($reports[0]->name) ? "Unknown" : $reports[0]->name ?> Reports <?= "- ".$progress ?></h2>
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
                                <th>Category</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($reports as $item) {
                                    if ($item->created_at) {
                                        $created_at = date("d F Y H:i:s", strtotime($item->created_at));
                                    } else {
                                        $created_at = "NULL";
                                    }
                                    echo '
                                        <tr>
                                            <td>'.strtoupper($item->category).'</td>
                                            <td>'.strtoupper($item->status).'</td>
                                            <td>'.$created_at.'</td>
                                            <td>
                                                <a href="" class="mdImage" data-image="'.base_url($item->image).'" data-toggle="modal" data-target="#mdImage"><i class="material-icons-outlined">visibility</i></a>
                                            </td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-content-center justify-content-center">
                    <img id="image" class="modal-content" alt="NULL" src="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#report').DataTable()
    })
    $('#report tbody').on('click', '.mdImage', function(){
        const image = $(this).data('image')
        $('#image').attr("src",image)
    })
</script>