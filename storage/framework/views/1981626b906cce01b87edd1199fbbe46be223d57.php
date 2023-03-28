<?php $__env->startSection('content'); ?>
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="show-filter mb-3 text-end">
                        <button class="btn btn--base showFilterBtn btn-sm" type="button"><i class="las la-filter"></i>
                            <?php echo app('translator')->get('Filter'); ?></button>
                    </div>
                    <div class="card responsive-filter-card custom__bg mb-4">
                        <div class="card-body">
                            <form action="">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="flex-grow-1">
                                        <label><?php echo app('translator')->get('Transaction Number'); ?></label>
                                        <input class="form-control" name="search" type="text" value="<?php echo e(request()->search); ?>">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label><?php echo app('translator')->get('Type'); ?></label>
                                        <select class="form-select form-control" name="trx_type">
                                            <option value=""><?php echo app('translator')->get('All'); ?></option>
                                            <option value="+" <?php if(request()->trx_type == '+'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Plus'); ?></option>
                                            <option value="-" <?php if(request()->trx_type == '-'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Minus'); ?></option>
                                        </select>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label><?php echo app('translator')->get('Remark'); ?></label>
                                        <select class="form-select form-control" name="remark">
                                            <option value=""><?php echo app('translator')->get('Any'); ?></option>
                                            <?php $__currentLoopData = $remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($remark->remark); ?>" <?php if(request()->remark == $remark->remark): echo 'selected'; endif; ?>>
                                                    <?php echo e(__(keyToTitle($remark->remark))); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="flex-grow-1 align-self-end">
                                        <button class="btn btn--base w-100"><i class="las la-filter"></i>
                                            <?php echo app('translator')->get('Filter'); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive--md">
                        <table class="custom--table table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Trx'); ?></th>
                                    <th><?php echo app('translator')->get('Transacted'); ?></th>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Post Balance'); ?></th>
                                    <th><?php echo app('translator')->get('Detail'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($trx->trx); ?></strong>
                                        </td>

                                        <td>
                                            <?php echo e(showDateTime($trx->created_at)); ?><br><?php echo e(diffForHumans($trx->created_at)); ?>

                                        </td>

                                        <td class="budget">
                                            <span
                                                class="fw-bold <?php if($trx->trx_type == '+'): ?> text-success <?php else: ?> text-danger <?php endif; ?>">
                                                <?php echo e($trx->trx_type); ?> <?php echo e(showAmount($trx->amount)); ?> <?php echo e($general->cur_text); ?>

                                            </span>
                                        </td>

                                        <td class="budget">
                                            <?php echo e(showAmount($trx->post_balance)); ?> <?php echo e(__($general->cur_text)); ?>

                                        </td>

                                        <td><?php echo e(__($trx->details)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="rounded-bottom text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($transactions->hasPages()): ?>
                        <div class="card-footer d-flex justify-content-center">
                            <?php echo e($transactions->links()); ?>

                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/lotter/core/resources/views/templates/basic/user/transactions.blade.php ENDPATH**/ ?>