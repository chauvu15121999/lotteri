<?php $__env->startSection('content'); ?>
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="card custom__bg">
                    <div class="card-body">
                        <?php if(auth()->user()->referrer): ?>
                            <h4 class="mb-2"><?php echo app('translator')->get('You are referred by'); ?> <?php echo e(auth()->user()->referrer->fullname); ?></h4>
                        <?php endif; ?>
                        <div class="col-md-12 mb-4">
                            <label><?php echo app('translator')->get('Referral Link'); ?></label>
                            <div class="input-group">
                                <input class="form--control referralURL" name="text" type="text" value="<?php echo e(route('home')); ?>?reference=<?php echo e(auth()->user()->username); ?>" readonly>
                                <span class="input-group-text copytext copyBoard" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                            </div>
                        </div>
                        <?php if($user->allReferrals->count() > 0 && $maxLevel > 0): ?>
                            <div class="treeview-container">
                                <ul class="treeview custom--bg">
                                    <li class="items-expanded"> <?php echo e($user->fullname); ?> ( <?php echo e($user->username); ?> )
                                        <?php echo $__env->make($activeTemplate . 'partials.under_tree', ['user' => $user, 'layer' => 0, 'isFirst' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link type="text/css" href="<?php echo e(asset('assets/global/css/jquery.treeView.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/global/js/jquery.treeView.js')); ?>"></script>
    <script>
        (function($) {
            "use strict"
            $('.treeview').treeView();
            $('.copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/lotter/core/resources/views/templates/basic/user/referral/referred.blade.php ENDPATH**/ ?>