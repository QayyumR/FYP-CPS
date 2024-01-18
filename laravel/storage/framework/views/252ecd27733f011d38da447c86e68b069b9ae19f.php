


<?php $__env->startSection('content'); ?>
<?php echo $__env->make('sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div style="padding-top:30px;" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Checked Out Item</div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Item Name</h6>
                            <strong><?php echo e($item->item_name); ?></strong>
                        </div>

                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Quantity</h6>
                            <strong><?php echo e($item->quantity); ?></strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Item Code</h6>
                            <strong><?php echo e($item->rfid_id); ?></strong>
                        </div>
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Location</h6>
                            <strong><?php echo e($item->location); ?></strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Customer</h6>
                            <strong><?php echo e($item->customer); ?></strong>
                        </div>
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Status</h6>
                            <?php if($item['status']=='Available'): ?>
                                    <span class="badge badge-success"> <?php echo e($item['status']); ?></span>
                                    <?php elseif($item['status']=='Unresolved'): ?>
                                    <span class="badge badge-warning" style='background-color:#F29A02; color:#fff;'> <?php echo e($item['status']); ?></span>
                                    <?php elseif($item['status']=='Lost'): ?>
                                    <span class="badge badge-danger" style='width:3rem;'> <?php echo e($item['status']); ?></span>
                                    <?php else: ?>
                                    <span class="badge badge-dark"> <?php echo e($item['status']); ?></span>
                                    <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                    <div class="col-12 col-sm-6 pb-5">
                            <h6>Check In Date</h6>
                            <strong><?php echo e(date('d-m-Y h:i A', strtotime($item->checkInDate))); ?></strong>
                        </div>
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Check Out Date</h6>
                            <strong><?php echo e(date('d-m-Y h:i A', strtotime($item->checkOutDate))); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container row" style='padding-top:1rem;'>

                <div class="clo-sm-1">
                    <button type="button" class="btn btn-secondary"><a class="text text-light text-decoration-none" href="checkout"><i class="fa fa-chevron-left"></i>  Back</a></button>
                </div>
                
                <div class="col-sm-1 offset-md-8">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#recheckin_item_modal"><i class="fa fa-undo"></i> Re-Check In</button>
                </div>

                <div class="col-sm-1" style='margin-left:5%;'>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_item_modal"><i class="fa fa-trash"></i> Delete Item</button>
                </div>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<!-- Re-Check In Item Modal -->
<div class="modal fade" id="recheckin_item_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/recheckinitem" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($item->id); ?>" required/>
                <input type="hidden" name="status" value="Available" required/>
                <div class="modal-header">
                    <h5 class="modal-title">Check Out Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to re-check in this item to your inventory?
                    </br>
                    </br>
                    </br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit">Re-Check In</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Delete Item Modal -->
<div class="modal fade" id="delete_item_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/deleteitem" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($item->id); ?>" required/>
                <div class="modal-header">
                    <h5 class="modal-title">Permanently Delete Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to permanently delete this item?
                    </br>
                    </br>
                    </br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cps\resources\views/viewcheckout.blade.php ENDPATH**/ ?>