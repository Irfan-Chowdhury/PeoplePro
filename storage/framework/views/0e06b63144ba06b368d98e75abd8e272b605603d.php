<?php $__env->startSection('body'); ?>


    <form action="<?php echo e(route('languages.translations.index', ['language' => $language])); ?>" method="get">

        <div class="container-fluid mt-3 mb-3">

            <div class="d-flex">

                <a href="<?php echo e(route('languages.create')); ?>" class="btn btn-primary mr-1">
                    <?php echo e(__('Add')); ?>

                </a>
                <div class="w-20">
                    <?php echo $__env->make('translation::forms.select', ['name' => 'language', 'items' => $languages, 'submit' => true, 'selected' => $language], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>

        <?php if(count($translations)): ?>

            <div class="table-responsive">
                <table id="language-table" class="table ">

                    <thead>
                    <tr>
                        <th class="w-1/5 uppercase font-thin"><?php echo e(__('translation::translation.key')); ?></th>

                        <th class="uppercase font-thin"><?php echo e(config('app.locale')); ?></th>
                        <th class="uppercase font-thin"><?php echo e($language); ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $__currentLoopData = $translations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $translations): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $translations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if(!is_array($value[config('app.locale')])): ?>
                                    <tr>
                                        <td><?php echo e($key); ?></td>
                                        <td><?php echo e($value[config('app.locale')]); ?></td>
                                        <td>
                                            <translation-input
                                                    initial-translation="<?php echo e($value[$language]); ?>"
                                                    language="<?php echo e($language); ?>"
                                                    group="<?php echo e($group); ?>"
                                                    translation-key="<?php echo e($key); ?>"
                                                    route="<?php echo e(config('translation.ui_url')); ?>"
                                            >
                                            </translation-input>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>
            </div>

        <?php endif; ?>

    </form>

    <script type="text/javascript">
        (function($) { 
            "use strict";

            $(document).ready(function () {

                var dataSrc = [];

                var table = $('#language-table').DataTable({

                    "order": [],
                    'language': {
                        'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
                        "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
                        "search": '<?php echo e(trans("file.Search")); ?>',
                        'paginate': {
                            'previous': '<?php echo e(trans("file.Previous")); ?>',
                            'next': '<?php echo e(trans("file.Next")); ?>'
                        }
                    },



                    'select': {style: 'multi', selector: 'td:first-child'},
                    'lengthMenu': [[100, 200, 500,-1], [100, 200, 500,"All"]],


                });

            });
        })(jQuery);
    </script>

<?php $__env->stopSection(); ?>





<?php echo $__env->make('translation::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lion-Coders\peoplepro\resources\views/vendor/translation/languages/translations/index.blade.php ENDPATH**/ ?>