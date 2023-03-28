<?php $__env->startSection('content'); ?>
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="table-responsive--md">
                        <table class="custom--table table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('S.N.'); ?></th>
                                    <th><?php echo app('translator')->get('Lottery Name'); ?></th>
                                    <th><?php echo app('translator')->get('Phase Number'); ?></th>
                                    <th><?php echo app('translator')->get('Ticket Number'); ?></th>
                                    <th><?php echo app('translator')->get('Win Bonus'); ?></th>
                                    <th><?php echo app('translator')->get('Winning Level'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $wins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $win): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($wins->firstItem() + $loop->index); ?></td>
                                        <td><?php echo e(__($win->tickets->lottery->name)); ?></td>
                                        <td><?php echo app('translator')->get('Phase'); ?># <?php echo e($win->tickets->phase->phase_number); ?></td>
                                        <td><?php echo e($win->ticket_number); ?></td>
                                        <td><?php echo e(getAmount($win->win_bonus)); ?> <?php echo e(__($general->cur_text)); ?></td>
                                        <td><?php echo app('translator')->get('Level'); ?> <?php echo e($win->level); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="rounded-bottom text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($wins->hasPages()): ?>
                        <div class="card-footer justify-content-center">
                            <?php echo e(paginateLinks($wins)); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/lotter/core/resources/views/templates/basic/user/lottery/wins.blade.php ENDPATH**/ ?>