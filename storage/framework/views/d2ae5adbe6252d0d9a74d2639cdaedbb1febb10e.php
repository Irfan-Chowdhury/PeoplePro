
<nav class="bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center pt-2 pb-2">
            <div>
                <a class="navbar-brand" href="#"><?php if($general_settings->site_logo ?? "no"): ?><img src="<?php echo e(url('public/logo', $general_settings->site_logo ?? "no")); ?>" width="50">&nbsp; &nbsp;<?php endif; ?><?php echo e($general_settings->site_title ?? "PeoplePro"); ?></a>
            </div>

            <div class="collapse navbar-collapse show" id="navbarTogglerDemo03">
                <nav class="my-2 my-md-0 mr-md-3 text-right">
                    <a class="p-2 text-dark" href="<?php echo e(route('home.front')); ?>"><?php echo e(trans('file.Home')); ?></a>
                    <a class="p-2 text-dark" href="<?php echo e(route('jobs')); ?>"><?php echo e(trans('file.Jobs')); ?></a>
                    <a class="p-2 text-dark" href="<?php echo e(route('about.front')); ?>"><?php echo e(trans('file.About')); ?></a>
                    <a class="p-2 text-dark" href="<?php echo e(route('contact.front')); ?>"><?php echo e(trans('file.Contact')); ?></a>
                </nav>
            </div>
        </div>
    </div>
</nav>

<?php /**PATH D:\xampp\htdocs\Lion_Coders\Peoplepro\Running_File\peoplepro\resources\views/frontend/Layout/navigation.blade.php ENDPATH**/ ?>