
<?php $__env->startSection('content'); ?>
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-30">
                    <table class="table-responsive--md custom--table table">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('S.N.'); ?></th>
                                <th><?php echo app('translator')->get('Lottery Name'); ?></th>
                                <th><?php echo app('translator')->get('Phase Number'); ?></th>
                                <th><?php echo app('translator')->get('Ticket'); ?></th>
                                <th><?php echo app('translator')->get('Result'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($tickets->firstItem() + $loop->index); ?></td>
                                    <td><?php echo e(__($ticket->lottery->name)); ?></td>
                                    <td><?php echo app('translator')->get('Phase ' . $ticket->phase->phase_number); ?></td>
                                    <td class="text-center">
                                        <?php echo e($ticket->ticket_number); ?>

                                    </td>
                                    <td>
                                        <?php
                                            echo $ticket->statusBadge;
                                        ?>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <td class="rounded-bottom text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        <?php if($tickets->hasPages()): ?>
                            <?php echo e(paginateLinks($tickets)); ?>

                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/lotter/core/resources/views/templates/basic/user/lottery/tickets.blade.php ENDPATH**/ ?>