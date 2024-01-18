


<?php $__env->startSection('content'); ?>
<?php echo $__env->make('sidebar.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div style="padding-top:30px;" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Item Detail</div>
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
                            <h6>Customer</h6>
                            <strong><?php echo e($item->customer); ?></strong>
                        </div>
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Location</h6>
                            <strong><?php echo e($item->location); ?></strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Check In Date</h6>
                            <strong><?php echo e($item->checkInDate); ?></strong>
                        </div>
                        <div class="col-12 col-sm-6 pb-5">
                            <h6>Check Out Date</h6>
                            <strong><?php echo e($item->checkOutDate); ?></strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h6>Item Code</h6>
                            <strong><?php echo e($item->rfid_id); ?></strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.sidemaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cps\resources\views/itemdetail.blade.php ENDPATH**/ ?>