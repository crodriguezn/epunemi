var ControlVentaCFAE_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    cfae_form_default: $.parseJSON('<?php echo json_encode($venta_cfae_form_default); ?>')
};
