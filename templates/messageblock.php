<?php if ($error) : ?>
<!--    <div class="row">
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert" href="#">×</a><?= $error ?>
        </div>
    </div> -->
<?php endif ?>

<!-- Modal -->
<div id="errorModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="errorbody" class="modal-body">
                <?= $error ?>
            </div>
        </div>
    </div>
</div>    <!-- Modal-->  
<?php if ($error) : ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#errorModal').modal('show');
        });
    </script>
    <?php
 endif ?>
