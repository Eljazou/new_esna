<?php
/**
 * Metronic 8 DataTables bundle (Bootstrap 5 skin).
 *
 * Drop-in replacement for the legacy Bootstrap 3 pair:
 *     $this->Html->css('dataTables.bootstrap');
 *     $this->Html->script('jquery.dataTables.min');
 *     $this->Html->script('dataTables.bootstrap.min');
 *
 * Usage — anywhere in a view, once per page:
 *     <?php echo $this->element('assets/datatables'); ?>
 *
 * DataTables is intentionally NOT in the global layout: it is ~400 KB and
 * only a subset of pages render tables, so it is opted into per page, the
 * same way Metronic's own demo pages do it.
 *
 * The CSS/JS are pushed into the layout's 'css' / 'script' blocks so they
 * land in <head> and just before </body> respectively, instead of being
 * emitted in the middle of the page body.
 */
echo $this->Html->css(
    '/metronic/demo1/dist/assets/plugins/custom/datatables/datatables.bundle',
    array('block' => 'css')
);
echo $this->Html->script(
    '/metronic/demo1/dist/assets/plugins/custom/datatables/datatables.bundle',
    array('block' => 'script')
);
