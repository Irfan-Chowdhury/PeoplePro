<html lang="en">
<head>
    <?php echo $__env->make('frontend.Layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="d-flex flex-column h-100">
	<?php echo $__env->make('frontend.Layout.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="frontend">
	    <?php echo $__env->yieldContent('content'); ?>
	</div>
	<footer class="footer mt-auto py-3 bg-dark text-center">
		<div class="container">
			<p class="mb-0 text-light">&copy; <?php echo e(__('PeoplePro')); ?>. <?php echo e(date('Y')); ?></p>
		</div>
	</footer>
</body>
</html><?php /**PATH D:\xampp\htdocs\Lion_Coders\Peoplepro\Running_File\peoplepro\resources\views/frontend/Layout/master.blade.php ENDPATH**/ ?>