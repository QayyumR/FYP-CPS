


<?php $__env->startSection('content'); ?>
<?php echo $__env->make('sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div style="padding-top:30px;" class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="card">
                <div class="card-header"><?php echo e(__('Scan Result')); ?></div>
                <div class="card-body">

                    <?php if($items->where('status','=', 'Unresolved')->count()): ?>

                    <div class="alert alert-success" role="alert">Results: <?php echo e($items->where('status','=', 'Available')->count()); ?> items are available in your inventory</div>
                    <div class="alert alert-danger" role="alert">Warning: <?php echo e($items->where('status','=', 'Unresolved')->count()); ?> items could not be found!</div>

                    <table id="example" class="table table-hover table-sm nowrap" style="width:100%">
                        <thead class="thead-dark" style='text-align: center'>
                            <tr>
                                <th>No</th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('item_name', 'Item Name', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('quantity', 'Quantity', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('customer', 'Customer', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('location', 'Location', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('status', 'Status', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody style='text-align: center'>
                            
                            <?php ($i = 1); ?>
                            <?php $__currentLoopData = $items->where('status','=', 'Unresolved'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($item['item_name']); ?></td>
                                <td><?php echo e($item['quantity']); ?></td>
                                <td><?php echo e($item['customer']); ?></td>
                                <td><?php echo e($item['location']); ?></td>
                                <td>
                                    <?php if($item['status']=='Available'): ?>
                                    <span class="badge badge-success"> <?php echo e($item['status']); ?></span>
                                    <?php elseif($item['status']=='Unresolved'): ?>
                                    <span class="badge badge-warning" style='background-color:#F29A02; color:#fff;'> <?php echo e($item['status']); ?></span>
                                    <?php elseif($item['status']=='Lost'): ?>
                                    <span class="badge badge-danger" style='width:3rem;'> <?php echo e($item['status']); ?></span>
                                    <?php else: ?>
                                    <span class="badge badge-dark"> <?php echo e($item['status']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="<?php echo e(route('setfound', $item->id)); ?>"> Found </a>
                                    <a class="btn btn-danger btn-sm" href="<?php echo e(route('setlost', $item->id)); ?>"> Lost</a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <?php echo $items->appends(\Request::except('page'))->render(); ?>


                    <style>
                        .w-5{
                            display:none;
                        }
                    </style>

                    <?php else: ?>

                        <div class="alert alert-success" role="alert">Great Job! All <?php echo e($items->where('status','=', 'Available')->count()); ?> items are available in your inventory</div>

                    <?php endif; ?>

                    </br>

                </div>

                <div class="card-footer">

                    <table id="example" class="table table-hover nowrap" style="width:100%">
                        <thead class="thead-dark" style='text-align: center'>
                            <tr>
                                <th style=width:25%;>Total Inventory Items</th>
                                <th style=width:25%;>Available Items</th>
                                <th style=width:25%;>Unresolved Items</th>
                                <th style=width:25%;>Lost Items</th>
                            </tr>
                        </thead>
                        <tbody style='text-align: center'>
                            <tr>
                                <td class="table-secondary"><?php echo e($items->count()); ?></td>
                                <td class="table-success"><?php echo e($items->where('status','=', 'Available')->count()); ?></td>
                                <td class="table-warning"><?php echo e($items->where('status','=', 'Unresolved')->count()); ?></td>
                                <td class="table-danger"><?php echo e($items->where('status','=', 'Lost')->count()); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="container row" style='padding-top:1rem;'>

                <div class="clo-sm-1">
                    <button type="button" class="btn btn-secondary"><a class="text text-light text-decoration-none" href="scaninventory"><i class="fa fa-chevron-left"></i>  Back</a></button>
                </div>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cps\resources\views/scanresult.blade.php ENDPATH**/ ?>