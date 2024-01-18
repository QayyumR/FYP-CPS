


<?php $__env->startSection('content'); ?>
<?php echo $__env->make('sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                    <button type="button" class="btn btn-secondary"><a class="text text-light text-decoration-none" href="inventory"><i class="fa fa-chevron-left"></i>  Back</a></button>
                </div>

                <div class="col-sm-1 offset-md-7" style='margin-left:66%;'>
                    <button type="button" class="btn btn-primary"><a class="text text-light text-decoration-none" href="<?php echo e(route('itempdf', $item->id)); ?>" target="_blank"><i class="fa fa-print"></i> Print </a></button>
                </div>
                
                <div class="col-sm-1" style='margin-left:0.3rem;'>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit_item_modal"><i class="fa fa-pen"></i> Edit</button>
                </div>

                <div class="col-sm-1">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#checkout_item_modal"><i class="fa fa-cash-register"></i> Check Out</button>
                </div>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>





<!-- Edit Item Modal -->
<div class="modal fade" id="edit_item_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="/edititem" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($item->id); ?>" required/>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Item Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Item Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="item_name" name="item_name" class="form-control" value="<?php echo e($item->item_name); ?>" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Item Code</label>
                            <div class="col-sm-9">
                                <input type="hex" id="rfid_id"name="rfid_id" class="form-control" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" pattern="[A-Fa-f0-9]{24,24}" maxlength="24" title="Must contain exactly 24 hexadecimal characters" value="<?php echo e($item->rfid_id); ?>" required/>
                                <?php if($errors->has('rfid_id')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('rfid_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Quantity</label>
                            <div class="col-sm-9">
                                <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo e($item->quantity); ?>" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Customer</label>
                            <div class="col-sm-9">
                                <input type="text" id="customer" name="customer" class="form-control" value="<?php echo e($item->customer); ?>" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Location</label>
                            <div class="col-sm-9">
                                <input type="text" id="location" name="location" class="form-control" value="<?php echo e($item->location); ?>" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select type="text" id="status" name="status" class="form-control">
                                    <option value="Available" <?php if($item['status']=="Available") echo 'selected="selected"'; ?>>Available</option>
                                    <option value="Unresolved" <?php if($item['status']=="Unresolved") echo 'selected="selected"'; ?>>Unresolved</option>
                                    <option value="Lost" <?php if($item['status']=="Lost") echo 'selected="selected"'; ?>>Lost</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Check In Date</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" id="checkInDate" name="checkInDate" class="form-control" value="<?php echo e(date('Y-m-d\TH:i', strtotime($item->checkInDate))); ?>" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Check Out Date</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" id="checkOutDate" name="checkOutDate" class="form-control" value="<?php echo e(date('Y-m-d\TH:i', strtotime($item->checkOutDate))); ?>" required/>
                            </div>
                        </div>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Check Out Item Modal -->
<div class="modal fade" id="checkout_item_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/checkoutitem" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($item->id); ?>" required/>
                <input type="hidden" name="status" value="Checked Out" required/>
                <div class="modal-header">
                    <h5 class="modal-title">Check Out Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to check out <?php echo e($item->item_name); ?> from your inventory ?
                    </br>
                    </br>
                    </br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Check Out</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cps\resources\views/viewitem.blade.php ENDPATH**/ ?>