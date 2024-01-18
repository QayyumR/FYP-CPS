


<?php $__env->startSection('content'); ?>
<?php echo $__env->make('sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div style="padding-top:30px;" class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="card">
                <div class="card-header"><?php echo e(__('Checked Out Item')); ?></div>
                <div class="card-body">
                    <table id="example" class="table table-hover table-sm nowrap" style="width:100%">
                        <thead class="thead-dark" style='text-align: center'>
                            <tr>
                                <th>No</th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('item_name', 'Item Name', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('quantity', 'Quantity', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('customer', 'Customer', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('status', 'Status', ['filter' => 'active, visible'], ['class' => 'text text-light text-decoration-none']));?></th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody style='text-align: center'>
                            
                            <?php ($i = 1); ?>
                            <?php if($items->count()): ?>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($item['item_name']); ?></td>
                                <td><?php echo e($item['quantity']); ?></td>
                                <td><?php echo e($item['customer']); ?></td>
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
                                    <a class="btn btn-outline-info btn-sm" style="width:2rem; height:2rem; padding-right:0.3rem;" href="<?php echo e(route('viewcheckout', $item->id)); ?>" ><i class="fa fa-info"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php echo $items->appends(\Request::except('page'))->render(); ?>


                    <style>
                        .w-5{
                            display:none;
                        }
                    </style>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cps\resources\views/checkout.blade.php ENDPATH**/ ?>